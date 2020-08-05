<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\Services;

use eArc\Serializer\Services\Interfaces\ObjectHashServiceInterface;

class ObjectHashService implements ObjectHashServiceInterface
{
    /** @var bool[] */
    protected $registeredIds;
    /** @var object[] */
    protected $referencedObjects;

    public function init(): void
    {
        $this->registeredIds = [];
        $this->referencedObjects = [];
    }

    public function isRegistered(object $object): bool
    {
        return array_key_exists(spl_object_id($object), $this->registeredIds);
    }

    public function registerObject(object $object): int
    {
        $id = spl_object_id($object);

        $this->registeredIds[$id] = true;

        return $id;
    }

    public function getReferencedObject(int $id): ?object
    {
        return array_key_exists($id, $this->referencedObjects) ? $this->referencedObjects[$id] : null;
    }

    public function referenceObject(int $id, object $object): void
    {
        $this->referencedObjects[$id] = $object;
    }
}
