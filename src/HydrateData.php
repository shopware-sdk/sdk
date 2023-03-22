<?php declare(strict_types=1);

namespace ShopwareSdk;

use ShopwareSdk\Model\CollectionInterface;

final class HydrateData
{
    public function map(array $data, string $class): object
    {
        $object = new $class();
        if ($object instanceof CollectionInterface) {
            $classMap = $object->getClassMap();
            foreach ($data as $item) {
                $object->entities[] = $this->map($item, $classMap);
            }
        } else {
            if (isset($data['id'])) {
                $object->id = $data['id'];
                unset($data['id']);
            }

            foreach ($data['attributes'] as $key => $value) {
                $this->checkValue($object, $key, $value);
            }
        }

        return $object;
    }

    private function setValue(object $object, string $key, mixed $value)
    {
        if (property_exists($object, $key)) {
            try {
                $object->$key = $value;
            } catch (\Throwable $e) {
                var_dump($object, $key, $value);
                die(PHP_EOL . '<br>die: ' . __FUNCTION__ .' / '. __FILE__ .' / '. __LINE__);
            }

        }
    }

    private function checkValue(object $object ,string|int $key, mixed $value): void
    {
        if (is_array($value)) {
            $class = '\\ShopwareSdk\\Model\\' . ucfirst((string)$key);
            if (class_exists($class)) {
                $subObject = new $class();
                foreach ($value as $subKey => $subValue) {
                    $this->checkValue($subObject, $subKey, $subValue);
                }
                $object->$key = $subObject;
            }
        } else {
            $this->setValue($object, $key, $value);
        }
    }
}
