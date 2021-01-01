<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\SerializerTypes;

use eArc\Serializer\DataTypes\NativeDataType;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;

class SerializerNativeType implements SerializerTypeInterface
{
    public function getDataTypes(): iterable
    {
        yield NativeDataType::class => null;
    }

    public function filterProperty(string $fQCN, string $propertyName): bool
    {
        return true;
    }
}
