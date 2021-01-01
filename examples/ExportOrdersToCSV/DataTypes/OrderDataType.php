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

use eArc\SerializerExamples\ExportOrdersToCSV\Entities\Order;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;
use eArc\Serializer\Services\SerializeService;

class OrderDataType extends AbstractDataType
{
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool
    {
        return $propertyValue instanceof Order;
    }

    public function serialize(?object $object, $propertyName, $propertyValue, SerializerTypeInterface $serializerType)
    {
        if ($propertyValue instanceof Order) {
            return array_merge(
                [
                    di_get(SerializeService::class)->serializeProperty($propertyValue, 'orderId', $propertyValue->orderId, $serializerType),
                ],
                di_get(SerializeService::class)->serializeProperty($propertyValue, 'customer', $propertyValue->customer, $serializerType).
                array_merge(...di_get(SerializeService::class)->serializeProperty($propertyValue, 'orderItems', $propertyValue->orderItems, $serializerType)),
            );
        }

        return [];
    }
}
