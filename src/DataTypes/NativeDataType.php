<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\DataTypes;

use eArc\Serializer\DataTypes\Interfaces\DataTypeInterface;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;

class NativeDataType implements DataTypeInterface
{
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool
    {
        return true;
    }

    public function serialize(?object $object, $propertyName, $propertyValue, SerializerTypeInterface $serializerType)
    {
        return serialize($propertyValue);
    }

    public function isResponsibleForDeserialization(?object $object, string $type, $value): bool
    {
        return true;
    }

    public function deserialize(?object $object, string $type, $value, SerializerTypeInterface $serializerType)
    {
        return unserialize($value);
    }
}
