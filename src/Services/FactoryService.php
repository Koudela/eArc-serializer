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
use eArc\Serializer\Exceptions\Interfaces\SerializeExceptionInterface;
use eArc\Serializer\Exceptions\SerializeException;
use eArc\Serializer\Services\Interfaces\FactoryServiceInterface;
use eArc\Serializer\Api\Interfaces\SerializerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class FactoryService implements FactoryServiceInterface
{
    public function deserializeProperty(?object $object, string $type, $value, ?array $runtimeDataTypes = null)
    {
        if (!is_null($runtimeDataTypes)) {
            foreach ($runtimeDataTypes as $className => $argument) {
                $dataType = di_get($className);
                if ($dataType->isResponsibleForDeserialization($object, $type, $value)) {
                    return $dataType->deserialize($object, $type, $value, $runtimeDataTypes);
                }
            }
        }

        /** @var $dataType DataTypeInterface */
        foreach (di_get_tagged(SerializerInterface::class) as $className => $argument) {
            $dataType = di_get($className);
            if ($dataType->isResponsibleForDeserialization($object, $type, $value)) {
                return $dataType->deserialize($object, $type, $value, $runtimeDataTypes);
            }
        }

        throw new SerializeException(sprintf(
            'There is no data type responsible for the deserialization of type %s.',
            $type
        ));
    }

    public function initObject(string $fQCN): object
    {
        try {
            return $this->getReflectionClass($fQCN)->newInstanceWithoutConstructor();
        } catch (ReflectionException $e) {
            throw new SerializeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function attachProperties(object $object, array $rawContent, ?array $runtimeDataTypes = null): object
    {
        $parent = get_class($object);

        while ($parent = get_parent_class($parent)) {
            $reflectionProperties = (new ReflectionClass($parent))->getProperties(ReflectionProperty::IS_PRIVATE);
            foreach ($reflectionProperties as $reflectionProperty) {
                $name = $reflectionProperty->getName();
                if (array_key_exists($name, $rawContent)) {
                    $reflectionProperty->setAccessible(true);
                    $reflectionProperty->setValue($object, $this->deserializeRawValue($object, $rawContent[$name], $runtimeDataTypes));
                }
            }
        }

        $reflectionClass = $this->getReflectionClass(get_class($object));

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $name = $reflectionProperty->getName();
            if (array_key_exists($name, $rawContent)) {
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($object, $this->deserializeRawValue($object, $rawContent[$name], $runtimeDataTypes));
            }
        }

        return $object;
    }

    public function deserializeRawValue(?object $object, $rawValue, ?array $runtimeDataTypes = null)
    {
        $type = is_array($rawValue) && array_key_exists('type', $rawValue) ? $rawValue['type'] : '';
        $value = is_array($rawValue) && array_key_exists('value', $rawValue) ? $rawValue['value'] : $rawValue;

        return $this->deserializeProperty($object, $type, $value, $runtimeDataTypes);
    }

    /**
     * @param string $fQCN
     *
     * @return ReflectionClass
     *
     * @throws SerializeExceptionInterface
     */
    protected function getReflectionClass(string $fQCN): ReflectionClass
    {
        static $reflectionClass = [];

        if (!array_key_exists($fQCN, $reflectionClass)) {
            try {
                $reflectionClass[$fQCN] = new ReflectionClass($fQCN);
            } catch (ReflectionException $e) {
                throw new SerializeException($e->getMessage(), $e->getCode(), $e);
            }
        }

        return $reflectionClass[$fQCN];
    }
}
