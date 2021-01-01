<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\Api;

use eArc\Serializer\Api\Interfaces\SerializerInterface;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;
use eArc\Serializer\SerializerTypes\SerializerDefaultType;
use eArc\Serializer\Services\FactoryService;
use eArc\Serializer\Services\ObjectHashService;
use eArc\Serializer\Services\SerializeService;

class Serializer implements SerializerInterface
{
    public function serialize($value, ?SerializerTypeInterface $serializerType = null): string
    {
        $serializerType ??= di_get(SerializerDefaultType::class);

        di_get(ObjectHashService::class)->init();

        $rawContent = di_get(SerializeService::class)->serializeProperty(null, '', $value, $serializerType);

        return json_encode($rawContent);
    }

    public function deserialize(string $serializedData, ?SerializerTypeInterface $serializerType = null)
    {
        $serializerType ??= di_get(SerializerDefaultType::class);

        $rawContent = json_decode($serializedData, true);

        di_get(ObjectHashService::class)->init();

        return di_get(FactoryService::class)->deserializeRawValue(null, $rawContent, $serializerType);
    }
}
