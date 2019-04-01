<?php declare(strict_types=1);

namespace Receipt\Application\StatusFix\Strategy;

use Chain\Adapter\Doctrine\Repository\ProductItemRepository;
use Chain\Domain\ValueObject\ProductItemStatus;
use Receipt\Adapter\Doctrine\ItemDbRepository;
use Receipt\Application\StatusFix\ReceiptIdsResult;

class ActiveChainItemsStrategy implements StatusFixStrategyInterface
{
    /** @var ItemDbRepository */
    private $itemDbRepository;
    /** @var ProductItemRepository */
    private $productItemRepository;

    public function __construct(ItemDbRepository $itemDbRepository, ProductItemRepository $productItemRepository)
    {
        $this->itemDbRepository = $itemDbRepository;
        $this->productItemRepository = $productItemRepository;
    }

    public function getReceiptIds(int $limit, int $offset = 0): ReceiptIdsResult
    {
        $productItemIds = $this->productItemRepository->getIdsByStatusWithLimit(new ProductItemStatus(ProductItemStatus::STATUS_ACTIVE), $limit, $offset);
        if (count($productItemIds)) {
            return new ReceiptIdsResult(
                array_unique($this->itemDbRepository->getPendingIdsByChainProductItemIds($productItemIds)),
                false
            );
        } else {
            return new ReceiptIdsResult([], true);
        }
    }

    public function getName(): string
    {
        return 'active_chain_items';
    }
}
