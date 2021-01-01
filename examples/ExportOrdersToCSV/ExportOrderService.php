<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\SerializerExamples\ExportOrdersToCSV;

use eArc\Serializer\Exceptions\SerializeException;
use eArc\Serializer\Services\SerializeService;

class ExportOrderService
{
    public function writeCSV(array $orders, string $filename): void
    {
        if (!$file = fopen($filename, 'w')) {
            throw new SerializeException(sprintf('%s is not writeable', $filename));
        }

        $serializeService = di_get(SerializeService::class);
        $exportOrderSerializerType = di_get(ExportOrderSerializerType::class);

        foreach ($orders as $order) {
            fputcsv(
                $file,
                $serializeService->serializeProperty(null, '', $order, $exportOrderSerializerType)
            );
        }

        fclose($file);
    }
}
