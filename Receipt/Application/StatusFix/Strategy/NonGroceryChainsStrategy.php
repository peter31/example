<?php declare(strict_types=1);

namespace Receipt\Application\StatusFix\Strategy;

use Chain\Domain\ValueObject\ChainLabel;
use Receipt\Adapter\Doctrine\ReceiptDbRepository;
use Receipt\Application\StatusFix\ReceiptIdsResult;
use Receipt\Domain\ValueObject\ReceiptOperationStatus;

class NonGroceryChainsStrategy implements StatusFixStrategyInterface
{
    /** @var ReceiptDbRepository */
    private $receiptDbRepository;

    public function __construct(ReceiptDbRepository $receiptDbRepository)
    {
        $this->receiptDbRepository = $receiptDbRepository;
    }

    public function getReceiptIds(int $limit, int $offset = 0): ReceiptIdsResult
    {
        return new ReceiptIdsResult(
            array_unique(
                $this->receiptDbRepository->getIdsByStatusesAndChainWithLabel(
                    [
                        new ReceiptOperationStatus(ReceiptOperationStatus::STATUS_CHAIN_REVIEW)
                    ],
                    new ChainLabel(ChainLabel::LABEL_NON_GROCERY)
                )
            ),
            false
        );
    }

    public function getName(): string
    {
        return 'non_grocery_chain';
    }
}
