<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\SerializerExamples\ExportOrdersToCSV\DataTypes;

use eArc\Serializer\DataTypes\Interfaces\DataTypeInterface;
use eArc\Serializer\Exceptions\SerializeException;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;
use eArc\Serializer\Services\SerializeService;

abstract class AbstractDataType implements DataTypeInterface
{
    public function serialize(?object $object, $propertyName, $propertyValue, SerializerTypeInterface $serializerType)
    {
        return di_get(SerializeService::class)->getAsArray($propertyValue, $serializerType);
    }

    public function isResponsibleForDeserialization(?object $object, string $type, $value): bool
    {
        throw new SerializeException('not supported');
    }

    public function deserialize(?object $object, string $type, $value, SerializerTypeInterface $serializerType)
    {
        throw new SerializeException('not supported');
    }
}
