<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\Services;

use eArc\Serializer\DataTypes\Interfaces\DataTypeInterface;
use eArc\Serializer\Exceptions\SerializeException;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;
use eArc\Serializer\Services\Interfaces\SerializeServiceInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class SerializeService implements SerializeServiceInterface
{
    public function getAsArray(object $object, SerializerTypeInterface $serializerType): array
    {
        $objectArray = [];

        $parent = get_class($object);
        $className = get_class($object);

        while ($parent = get_parent_class($parent)) {
            try {
                $reflectionProperties = (new ReflectionClass($parent))->getProperties(ReflectionProperty::IS_PRIVATE);
            } catch (ReflectionException $e) {
                throw new SerializeException($e->getMessage(), $e->getCode(), $e);
            }
            foreach ($reflectionProperties as $reflectionProperty) {
                $propertyName = $reflectionProperty->getName();
                if ($serializerType->filterProperty($className, $propertyName)) {
                    $reflectionProperty->setAccessible(true);
                    $propertyValue = $reflectionProperty->getValue($object);
                    $objectArray[$propertyName] = $this->serializeProperty($object, $propertyName, $propertyValue, $serializerType);
                }
            }
        }

        $reflectionProperties = (new ReflectionClass($object))->getProperties();

        foreach ($reflectionProperties as $reflectionProperty) {
            $propertyName = $reflectionProperty->getName();
            if ($serializerType->filterProperty($className, $propertyName)) {
                $reflectionProperty->setAccessible(true);
                $propertyValue = $reflectionProperty->getValue($object);
                $objectArray[$propertyName] = $this->serializeProperty($object, $propertyName, $propertyValue, $serializerType);
            }
        }

        return $objectArray;
    }

    public function serializeProperty(?object $object, $propertyName, $propertyValue, SerializerTypeInterface $serializerType)
    {
        /** @var DataTypeInterface $dataType */
        foreach ($serializerType->getDataTypes() as $className => $dataType) {
            if (is_null($dataType)) {
                $dataType = di_get($className);
            }
            if ($dataType->isResponsibleForSerialization($object, $propertyName, $propertyValue)) {
                return $dataType->serialize($object, $propertyName, $propertyValue, $serializerType);
            }
        }

        throw new SerializeException(sprintf(
            'There is no data type responsible for the serialization of object %s and property Name %s.',
            is_null($object) ? 'NULL' : get_class($object),
            $propertyName
        ));
    }
}
