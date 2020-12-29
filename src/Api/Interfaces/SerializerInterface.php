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

use eArc\Serializer\Exceptions\Interfaces\SerializeExceptionInterface;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;

interface SerializerInterface
{
    /**
     * @param int|float|string|array|object|null $value
     * @param SerializerTypeInterface|null $serializerType
     * @return string
     *
     * @throws SerializeExceptionInterface
     */
    public function serialize($value, ?SerializerTypeInterface $serializerType = null): string;

    /**
     * @param string $serializedData
     * @param SerializerTypeInterface|null $serializerType
     *
     * @return int|float|string|array|object|null
     *
     * @throws SerializeExceptionInterface
     */
    public function deserialize(string $serializedData, ?SerializerTypeInterface $serializerType = null);
}
