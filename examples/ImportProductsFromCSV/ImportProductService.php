<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\SerializerExamples\ImportProductsFromCSV;

use eArc\Serializer\Exceptions\SerializeException;
use eArc\Serializer\SerializerTypes\SerializerDefaultType;
use eArc\Serializer\Services\FactoryService;
use eArc\SerializerExamples\ImportProductsFromCSV\Entities\Product;
use eArc\SerializerExamples\ImportProductsFromCSV\Entities\ProductImage;

class ImportProductService
{
    public function readCSV(string $filename): void
    {
        if (!$file = fopen($filename, 'r')) {
            throw new SerializeException(sprintf('%s is not readable', $filename));
        }

        $factoryService = di_get(FactoryService::class);
        $serializerType = di_get(SerializerDefaultType::class);

        while ($row = fgetcsv($file)) {
            /** @var Product $product */
            $product = $factoryService->deserializeProperty(null, Product::class, [
                'ean' => $row[0],
                'name' => $row[1],
                'description' => $row[2],
                'price' => (int) $row[3],
                'currency' => $row[4],
            ], $serializerType);
            /** @var ProductImage $image */
            $image = $factoryService->deserializeProperty(null, ProductImage::class, [
                'product' => $product,
                'path' => $row[5],
            ], $serializerType);
            $product->image = $image;
            $this->persist($product);
            $this->persist($image);
        }

        fclose($file);
    }

    protected function persist(object $object): void
    {
        // persisting code goes here
    }
}
