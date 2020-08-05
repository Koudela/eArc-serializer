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
use eArc\Serializer\Api\Interfaces\SerializerInterface;
use eArc\Serializer\Exceptions\SerializeException;
use eArc\Serializer\Services\Interfaces\SerializeServiceInterface;
use ReflectionClass;
use ReflectionException;

class SerializeService implements SerializeServiceInterface
{
    public function getAsArray(object $object): array
    {
        $objectArray = [];

        try {
            $reflectionProperties = (new ReflectionClass($object))->getProperties();
        } catch (ReflectionException $e) {
            throw new SerializeException($e->getMessage(), $e->getCode(), $e);
        }

        foreach ($reflectionProperties as $reflectionProperty) {
            $reflectionProperty->setAccessible(true);
            $propertyValue = $reflectionProperty->getValue($object);
            $propertyName = $reflectionProperty->getName();
            $objectArray[$propertyName] = $this->serializeProperty($object, $propertyName, $propertyValue);
        }

        return $objectArray;
    }

    public function serializeProperty(?object $object, $propertyName, $propertyValue)
    {
        /** @var DataTypeInterface $dataType */
        foreach (di_get_tagged(SerializerInterface::class) as $className => $argument) {
            $dataType = di_get($className);
            if ($dataType->isResponsibleForSerialization($object, $propertyName, $propertyValue)) {
                return $dataType->serialize($object, $propertyName, $propertyValue);
            }
        }

        throw new SerializeException(sprintf(
            'There is no data type responsible for the serialization of object %s and property Name %s.',
            is_null($object) ? 'NULL' : get_class($object),
            $propertyName
        ));
    }
}