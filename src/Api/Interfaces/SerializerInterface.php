<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\Api\Interfaces;

use eArc\Serializer\DataTypes\Interfaces\DataTypeInterface;
use eArc\Serializer\Exceptions\Interfaces\SerializeExceptionInterface;

interface SerializerInterface
{
    /**
     * @param int|float|string|array|object|null $value
     * @param FilterInterface[]|null $filter #TODO Filter
     * @param DataTypeInterface[]|null $runtimeDataTypes
     *
     * @return string
     *
     * @throws SerializeExceptionInterface
     */
    public function serialize($value, ?array $filter = null, ?array $runtimeDataTypes = null): string;

    /**
     * @param string $serializedData
     * @param FilterInterface[]|null $filter #TODO Filter
     * @param DataTypeInterface[]|null $runtimeDataTypes
     *
     * @return int|float|string|array|object|null
     *
     * @throws SerializeExceptionInterface
     */
    public function deserialize(string $serializedData, ?array $filter = null, ?array $runtimeDataTypes = null);
}
