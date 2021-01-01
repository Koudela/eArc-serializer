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

class OrderItem
{
    public int $quantity;
    public string $ean;
    public string $name;
    public string $description;
    public int $price;
    public string $currency;
    public int $tax;
    public ?string $imageId;
    public ?string $packageId;

    public function isSend(): bool
    {
        return !is_null($this->packageId);
    }
}
