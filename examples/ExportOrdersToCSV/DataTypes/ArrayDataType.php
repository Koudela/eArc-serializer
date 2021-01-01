<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\SerializerExamples\ExportOrdersToCSV\DataTypes;

class ArrayDataType extends AbstractDataType
{
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool
    {
        return is_array($propertyValue);
    }
}
