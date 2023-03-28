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
            $propertyName = lcfirst((string)$key);

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
}
