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

interface SerializeServiceInterface
{
    /**
     * @param object $object
     *
     * @return array
     *
     * @throws SerializeExceptionInterface
     */
    public function getAsArray(object $object): array;

    /**
     * @param object|null $object
     * @param string|int $propertyName
     * @param int|float|string|array|object|null $propertyValue
     *
     * @return int|float|string|array|null
     *
     * @throws SerializeExceptionInterface
     */
    public function serializeProperty(?object $object, $propertyName, $propertyValue);
}
