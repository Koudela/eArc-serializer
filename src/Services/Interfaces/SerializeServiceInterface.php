<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\Services\Interfaces;

use eArc\Serializer\Exceptions\Interfaces\SerializeExceptionInterface;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;

interface SerializeServiceInterface
{
    /**
     * @param object $object
     * @param SerializerTypeInterface $serializerType
     *
     * @return array
     *
     * @throws SerializeExceptionInterface
     */
    public function getAsArray(object $object, SerializerTypeInterface $serializerType): array;

    /**
     * @param object|null $object
     * @param string|int $propertyName
     * @param int|float|string|array|object|null $propertyValue
     * @param SerializerTypeInterface $serializerType
     * @return int|float|string|array|null
     *
     * @throws SerializeExceptionInterface
     */
    public function serializeProperty(?object $object, $propertyName, $propertyValue, SerializerTypeInterface $serializerType);
}
