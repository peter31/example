<?php declare(strict_types=1);

namespace Receipt\Tests\Application\StatusFix\Strategy;

use Chain\Adapter\Doctrine\Repository\ProductItemRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Receipt\Adapter\Doctrine\ItemDbRepository;
use Receipt\Application\StatusFix\Strategy\ActiveChainItemsStrategy;
use Snapcart\TestBundle\Controller\AbstractTest;

/**
 * bin/phpunit -c tests src/Receipt/Tests/Application/StatusFix/Strategy/ActiveChainItemsStrategyTest.php
 */
class ActiveChainItemsStrategyTest extends AbstractTest
{
    /** @var ItemDbRepository|MockObject */
    private $itemDbRepository;
    /** @var ProductItemRepository|MockObject */
    private $productItemRepository;
    /** @var ActiveChainItemsStrategy */
    private $strategy;

    public function setUp()
    {
        $this->itemDbRepository = $this->createMock(ItemDbRepository::class);
        $this->productItemRepository = $this->createMock(ProductItemRepository::class);
        $this->strategy = new ActiveChainItemsStrategy($this->itemDbRepository, $this->productItemRepository);
    }

    /** @test */
    public function getReceiptIds()
    {
        $this->productItemRepository->expects($this->once())->method('getIdsByStatusWithLimit')->willReturn([1]);
        $this->itemDbRepository->expects($this->once())->method('getPendingIdsByChainProductItemIds')->with([1])->willReturn([2]);

        $result = $this->strategy->getReceiptIds(10);
        $this->assertEquals([2], $result->getData());
        $this->assertEquals(false, $result->getFinished());
    }

    /** @test */
    public function getReceiptIdsNoReceipts()
    {
        $this->productItemRepository->expects($this->once())->method('getIdsByStatusWithLimit')->willReturn([1]);
        $this->itemDbRepository->expects($this->once())->method('getPendingIdsByChainProductItemIds')->with([1])->willReturn([]);

        $result = $this->strategy->getReceiptIds(10);
        $this->assertEquals([], $result->getData());
        $this->assertEquals(false, $result->getFinished());
    }

    /** @test */
    public function getReceiptIdsFinished()
    {
        $this->productItemRepository->expects($this->once())->method('getIdsByStatusWithLimit')->willReturn([]);

        $result = $this->strategy->getReceiptIds(10);
        $this->assertEquals([], $result->getData());
        $this->assertEquals(true, $result->getFinished());
    }
}
