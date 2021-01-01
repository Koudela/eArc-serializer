<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Serializer\Services\Interfaces;

interface ObjectHashServiceInterface
{
    public function init(): void;

    public function isRegistered(object $object): bool;

    public function registerObject(object $object): int;

    public function getReferencedObject(int $id): ?object;

    public function referenceObject(int $id, object $object): void;

}
