<?php declare(strict_types=1);

namespace Receipt\Application\StatusFix\Strategy;

use Receipt\Application\StatusFix\ReceiptIdsResult;

interface StatusFixStrategyInterface
{
    public function getName(): string;

    public function getReceiptIds(int $limit, int $offset = 0): ReceiptIdsResult;
}
