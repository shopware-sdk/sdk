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
                if(is_array($value)) {
                    $class = '\\ShopwareSdk\\Model\\' . ucfirst($key);
                    if(class_exists($class)) {
                        $subObject = new $class();
                        foreach ($value as $subKey => $subValue) {
                            $this->setValue($subObject, $subKey, $subValue);
                        }
                        $object->$key = $subObject;
                    }
                } else {
                    $this->setValue($object, $key, $value);
                }
            }
        }

        return $object;
    }

    private function setValue(object $object, string $key, mixed $value)
    {
        if (property_exists($object, $key)) {
            $object->$key = $value;
        }
    }
}
