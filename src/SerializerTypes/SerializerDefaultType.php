<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\SerializerTypes;

use eArc\Serializer\DataTypes\ArrayDataType;
use eArc\Serializer\DataTypes\ClassDataType;
use eArc\Serializer\DataTypes\DateTimeDataType;
use eArc\Serializer\DataTypes\ObjectDataType;
use eArc\Serializer\DataTypes\SimpleDataType;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;

class SerializerDefaultType implements SerializerTypeInterface
{
    public function getDataTypes(): iterable
    {
        yield DateTimeDataType::class => null;
        yield SimpleDataType::class => null;
        yield ArrayDataType::class => null;
        yield ClassDataType::class => null;
        yield ObjectDataType::class => null;
    }

    public function filterProperty(string $fQCN, string $propertyName): bool
    {
        return true;
    }
}
