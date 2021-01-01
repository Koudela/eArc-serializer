<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\SerializerExamples\ExportOrdersToCSV;

use eArc\SerializerExamples\ExportOrdersToCSV\DataTypes\ArrayDataType;
use eArc\SerializerExamples\ExportOrdersToCSV\DataTypes\CustomerDataType;
use eArc\SerializerExamples\ExportOrdersToCSV\DataTypes\OrderDataType;
use eArc\SerializerExamples\ExportOrdersToCSV\DataTypes\OrderItemDataType;
use eArc\Serializer\DataTypes\SimpleDataType;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;

class ExportOrderSerializerType implements SerializerTypeInterface
{
    public function getDataTypes(): iterable
    {
        yield ArrayDataType::class => null;
        yield CustomerDataType::class => null;
        yield OrderItemDataType::class => null;
        yield OrderDataType::class => null;
        yield SimpleDataType::class => null;
    }

    public function filterProperty(string $fQCN, string $propertyName): bool
    {
        return true;
    }
}
