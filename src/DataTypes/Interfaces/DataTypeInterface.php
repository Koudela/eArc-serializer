<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\DataTypes\Interfaces;

use eArc\Serializer\Exceptions\Interfaces\SerializeExceptionInterface;

interface DataTypeInterface
{
    /**
     * @param object|null $object
     * @param string|int $propertyName
     * @param int|float|string|array|object|null $propertyValue
     *
     * @return bool
     */
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool;

    /**
     * @param object|null $object
     * @param string|int $propertyName
     * @param int|float|string|array|object|null $propertyValue
     * @param array|null $runtimeDataTypes
     *
     * @return int|float|string|array|null
     *
     * @throws SerializeExceptionInterface
     */
    public function serialize(?object $object, $propertyName, $propertyValue, ?array $runtimeDataTypes = null);

    /**
     * @param object|null $object
     * @param string $type
     * @param int|float|string|array|null $value
     *
     * @return bool
     */
    public function isResponsibleForDeserialization(?object $object, string $type, $value): bool;

    /**
     * @param object|null $object
     * @param string $type
     * @param int|float|string|array|null $value
     * @param array|null $runtimeDataTypes
     *
     * @return int|float|string|array|object|null
     *
     * @throws SerializeExceptionInterface
     */
    public function deserialize(?object $object, string $type, $value, ?array $runtimeDataTypes = null);
}
