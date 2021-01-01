<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\Services\Interfaces;

use eArc\Serializer\Exceptions\Interfaces\SerializeExceptionInterface;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;

interface FactoryServiceInterface
{
    /**
     * @param object|null $object
     * @param string $type
     * @param int|float|string|array|null $value
     * @param SerializerTypeInterface $serializerType
     *
     * @return int|float|string|array|object|null
     *
     * @throws SerializeExceptionInterface
     */
    public function deserializeProperty(?object $object, string $type, $value, SerializerTypeInterface $serializerType);

    /**
     * @param string $fQCN
     *
     * @return object
     *
     * @throws SerializeExceptionInterface
     */
    public function initObject(string $fQCN): object;

    /**
     * @param object $object
     * @param array $rawContent
     * @param SerializerTypeInterface $serializerType
     *
     * @return object
     *
     * @throws SerializeExceptionInterface
     */
    public function attachProperties(object $object, array $rawContent, SerializerTypeInterface $serializerType): object;
}
