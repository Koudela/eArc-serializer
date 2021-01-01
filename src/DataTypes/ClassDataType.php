<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\DataTypes;

use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;
use eArc\Serializer\Services\FactoryService;
use eArc\Serializer\DataTypes\Interfaces\DataTypeInterface;
use eArc\Serializer\Services\ObjectHashService;
use eArc\Serializer\Services\SerializeService;

class ClassDataType implements DataTypeInterface
{
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool
    {
        return is_object($propertyValue) && get_class($propertyValue) !== 'stdClass';
    }

    public function serialize(?object $object, $propertyName, $propertyValue, SerializerTypeInterface $serializerType): array
    {
        $objectHashService = di_get(ObjectHashService::class);

        $isRegistered = $objectHashService->isRegistered($propertyValue);
        $id = $objectHashService->registerObject($propertyValue);

        return [
            'type' => $isRegistered ? ObjectHashService::class : get_class($propertyValue),
            'value' => [
                'content' => $isRegistered ? null : di_get(SerializeService::class)->getAsArray($propertyValue, $serializerType),
                'id' => $id,
            ],
        ];
    }
    public function isResponsibleForDeserialization(?object $object, string $type, $value): bool
    {
        return class_exists($type);
    }

    public function deserialize(?object $object, string $type, $value, SerializerTypeInterface $serializerType)
    {
        $id = is_array($value) && array_key_exists('id', $value) ? $value['id'] : null;

        if (!is_null($id)) {
            $objectHashService = di_get(ObjectHashService::class);

            if ($object = $objectHashService->getReferencedObject($id)) {
                return $object;
            }
        }

        $object = di_get(FactoryService::class)->initObject($type);

        if (!is_null($id)) {
            $objectHashService->referenceObject($id, $object);
        }

        $content = is_array($value) && array_key_exists('content', $value) ? $value['content'] : $value;

        return di_get(FactoryService::class)->attachProperties($object, $content, $serializerType);
    }
}
