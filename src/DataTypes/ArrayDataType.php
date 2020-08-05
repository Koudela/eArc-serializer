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

class ArrayDataType implements DataTypeInterface
{
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool
    {
        return is_array($propertyValue);
    }

    public function serialize(?object $object, $propertyName, $propertyValue)
    {
        $serialized = [];

        /** @var array $propertyValue */
        foreach ($propertyValue as $key => $value) {
            $serialized[$key] = di_get(SerializeService::class)->serializeProperty(null, $key, $value);
        }

        return [
            'type' => 'array',
            'value' => $serialized,
        ];
    }

    public function isResponsibleForDeserialization(?object $object, string $type, $value): bool
    {
        return $type === 'array';
    }

    public function deserialize(?object $object, string $type, $value)
    {
        $deserialized = [];

        /** @var array $value */
        foreach ($value as $key => $val) {
            $deserialized[$key] = di_get(FactoryService::class)->deserializeRawValue($object, $val);
        }

        return $deserialized;
    }
}
