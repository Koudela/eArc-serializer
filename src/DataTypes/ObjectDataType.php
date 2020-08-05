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

use eArc\Serializer\Services\FactoryService;
use eArc\Serializer\DataTypes\Interfaces\DataTypeInterface;
use eArc\Serializer\Services\SerializeService;

class ObjectDataType implements DataTypeInterface
{
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool
    {
        return is_object($propertyValue) && get_class($propertyValue) === 'stdClass';
    }

    public function serialize(?object $object, $propertyName, $propertyValue)
    {
        $objectArray = [];

        foreach (get_object_vars($propertyValue) as $key => $value) {
            $objectArray[$key] = di_get(SerializeService::class)->serializeProperty($object, '', $value);
        }

        return [
            'type' => 'object',
            'value' => $objectArray,
        ];
    }

    public function isResponsibleForDeserialization(?object $object, string $type, $value): bool
    {
        return $type === 'object';
    }

    public function deserialize(?object $object, string $type, $value)
    {
        $object = [];

        foreach ($value as $key => $rawValue) {
            $object[$key] = di_get(FactoryService::class)->deserializeRawValue(null, $rawValue);
        }

        return (object) $object;
    }
}
