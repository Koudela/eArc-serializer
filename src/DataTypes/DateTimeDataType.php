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

use DateTime;
use DateTimeZone;
use eArc\Serializer\DataTypes\Interfaces\DataTypeInterface;
use eArc\Serializer\Exceptions\SerializeException;
use Exception;

class DateTimeDataType implements DataTypeInterface
{
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool
    {
        return is_object($propertyValue) && get_class($propertyValue) === DateTime::class;
    }

    public function serialize(?object $object, $propertyName, $propertyValue, ?array $runtimeDataTypes = null): array
    {
        return [
            'type' => DateTime::class,
            'value' => json_encode($propertyValue),
        ];
    }

    public function isResponsibleForDeserialization(?object $object, string $type, $value): bool
    {
        return $type === DateTime::class;
    }

    public function deserialize(?object $object, string $type, $value, ?array $runtimeDataTypes = null): object
    {
        $rawObject = json_decode($value);

        try {
            return new DateTime($rawObject->date, new DateTimeZone($rawObject->timezone));
        } catch (Exception $e) {
            throw new SerializeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
