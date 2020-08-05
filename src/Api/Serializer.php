<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\Api;

use eArc\Serializer\Api\Interfaces\SerializerInterface;
use eArc\Serializer\Services\FactoryService;
use eArc\Serializer\Services\ObjectHashService;
use eArc\Serializer\Services\SerializeService;

class Serializer implements SerializerInterface
{
    public function serialize($value): string
    {
        di_get(ObjectHashService::class)->init();

        $rawContent = di_get(SerializeService::class)->serializeProperty(null, '', $value);

        return json_encode($rawContent);
    }

    public function deserialize(string $serializedData)
    {
        $rawContent = json_decode($serializedData, true);

        di_get(ObjectHashService::class)->init();

        return di_get(FactoryService::class)->deserializeRawValue(null, $rawContent);
    }
}
