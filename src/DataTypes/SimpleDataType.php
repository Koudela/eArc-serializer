<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\DataTypes;

use eArc\Serializer\DataTypes\Interfaces\DataTypeInterface;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;

class SimpleDataType implements DataTypeInterface
{
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool
    {
        return is_int($propertyValue) || is_string($propertyValue) || is_float($propertyValue) || is_bool($propertyValue) || is_null($propertyValue);
    }

    public function serialize(?object $object, $propertyName, $propertyValue, SerializerTypeInterface $serializerType)
    {
        return $propertyValue;
    }

    public function isResponsibleForDeserialization(?object $object, string $type, $value): bool
    {
        return !$type;
    }

    public function deserialize(?object $object, string $type, $value, SerializerTypeInterface $serializerType)
    {
        return $value;
    }
}
