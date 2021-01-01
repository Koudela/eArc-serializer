<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\SerializerExamples\ExportOrdersToCSV\Entities;

class Order
{
    public string $orderId;
    /** @var OrderItem[] */
    public array $orderItems = [];
    public Customer $customer;

    public function __construct(string $orderId, Customer $customer)
    {
        $this->orderId = $orderId;
        $this->customer = $customer;
    }
}
