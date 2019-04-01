<?php declare(strict_types=1);

namespace Receipt\Application\StatusFix\Strategy;

use Chain\Adapter\Doctrine\Repository\ChainRepository;
use Receipt\Adapter\Doctrine\ReceiptDbRepository;
use Receipt\Application\StatusFix\ReceiptIdsResult;
use Receipt\Domain\ValueObject\ReceiptOperationStatus;

class VerifiedChainsStrategy implements StatusFixStrategyInterface
{
    /** @var ReceiptDbRepository */
    private $receiptDbRepository;
    /** @var ChainRepository */
    private $chainRepository;

    public function __construct(ReceiptDbRepository $receiptDbRepository, ChainRepository $chainRepository)
    {
        $this->receiptDbRepository = $receiptDbRepository;
        $this->chainRepository = $chainRepository;
    }

    public function getReceiptIds(int $limit, int $offset = 0): ReceiptIdsResult
    {
        $chainIds = $this->chainRepository->getIdsVerifiedWithLimit(true, $limit, $offset);
        if (count($chainIds)) {
            return new ReceiptIdsResult(
                array_unique(
                    $this->receiptDbRepository->getIdsByStatusAndChainIds(
                        new ReceiptOperationStatus(ReceiptOperationStatus::STATUS_CHAIN_REVIEW),
                        $chainIds
                    )
                ),
                false
            );
        } else {
            return new ReceiptIdsResult([], true);
        }
    }

    public function getName(): string
    {
        return 'verified_chain';
    }
}
