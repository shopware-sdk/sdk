<?php declare(strict_types=1);

namespace ShopwareSdk;

use ShopwareSdk\Model\CollectionInterface;
use ReflectionClass;

final class HydrateData
{
    public function map(array $data, string $class): object
    {
        $object = new $class();
        if ($object instanceof CollectionInterface) {
            $classMap = $object->getClassMap();
            foreach ($data as $item) {
                $entity = $this->mapArrayToClass($item['attributes'], $classMap);
                if (isset($item['id'])) {
                    $entity->id = $item['id'];
                }
                $object->entities[] = $entity;
            }
        } else {
            $object = $this->mapArrayToClass($data['attributes'], $class);
            if (isset($data['id'])) {
                $object->id = $data['id'];
            }
        }

        return $object;
    }


    public function mapArrayToClass(array $data, string $class)
    {
        $object = new $class();

        foreach ($data as $key => $value) {
            $propertyName = lcfirst($key);

            if (property_exists($object, $propertyName)) {
                if (is_array($value) && !empty($value)) {
                    $reflectionProperty = (new ReflectionClass($object))->getProperty($propertyName);
                    $docComment = $reflectionProperty->getDocComment();

                    if ($docComment && preg_match('/@var\s+([\\\\\\w]+)(\[\]|)/', $docComment, $matches)) {
                        $propertyType = $matches[1];
                        $isArray = $matches[2] === '[]';
                    } else {
                        $propertyType = (string) $reflectionProperty->getType();
                        $isArray = $reflectionProperty->getType()?->allowsNull() && in_array($value, [null], true);
                        $propertyType = ltrim($propertyType, '?');
                    }

                    if ($propertyType) {
                        if ($isArray) {
                            $value = array_map(fn($item) => $this->mapArrayToClass($item, $propertyType), $value);
                        } else {
                            $value = $this->mapArrayToClass($value, $propertyType);
                        }
                    }
                }

                $object->$propertyName = $value;
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

    private function checkValue(object $object, string|int $key, mixed $value): void
    {
        if (is_array($value)) {
            $class = '\\ShopwareSdk\\Model\\' . ucfirst((string)$key);
            if (class_exists($class)) {
                $subObject = new $class();
                foreach ($value as $subKey => $subValue) {

                    if (property_exists($subObject, (string)$subKey)) {
                        $reflection = new \ReflectionProperty($subObject::class, $subKey);
                        $docBlockComment = $reflection->getDocComment();
                        if ($docBlockComment) {
                            $pattern = '/@var\s+([^\s]+)/';
                            preg_match($pattern, $docBlockComment, $matches);
                            $type = trim(str_replace(['|', 'null'], '', $matches[1]));
                            $one = substr($type, -2);
                            $two = substr($type, 0, -2);
                            if (substr($type, -2) === '[]' && class_exists(substr($type, 0, -2))) {
                                $test = substr($type, 0, -2);
                            }
                        }
                    }

                    $this->checkValue($subObject, $subKey, $subValue);
                }
                $object->$key = $subObject;
            }
        } else {
            $this->setValue($object, $key, $value);
        }
    }
}
