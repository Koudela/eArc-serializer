<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\SerializerExamples\ExportOrdersToCSV\Entities;

class Customer
{
    public string $forename;
    public string $surname;
    public string $street;
    public string $houseNumber;
    public string $postalCode;
    public string $city;
    public string $country;
    public string $telephone;
}
