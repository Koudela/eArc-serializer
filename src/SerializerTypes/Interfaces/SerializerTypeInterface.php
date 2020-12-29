<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\SerializerTypes\Interfaces;

interface SerializerTypeInterface
{
    /**
     * The returned data types are checked for responsibility. The first responsible
     * data type is used to serialize/deserialize the current value.
     *
     * @return iterable over DataTypeInterfaces
     */
    public function getDataTypes(): iterable;

    /**
     * The value of an object property will be serialized iff this function returns
     * true.
     *
     * Hint: The data type used for serialization may not support this feature.
     *
     * @param string $fQCN
     * @param string $propertyName
     *
     * @return bool
     */
    public function filterProperty(string $fQCN, string $propertyName): bool;
}
