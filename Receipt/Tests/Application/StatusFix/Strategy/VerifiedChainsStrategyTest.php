<?php declare(strict_types=1);

namespace Receipt\Tests\Application\StatusFix\Strategy;

use Chain\Adapter\Doctrine\Repository\ChainRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Receipt\Adapter\Doctrine\ReceiptDbRepository;
use Receipt\Application\StatusFix\Strategy\ActiveChainItemsStrategy;
use Receipt\Application\StatusFix\Strategy\VerifiedChainsStrategy;
use Snapcart\TestBundle\Controller\AbstractTest;

/**
 * bin/phpunit -c tests src/Receipt/Tests/Application/StatusFix/Strategy/VerifiedChainsStrategyTest.php
 */
class VerifiedChainsStrategyTest extends AbstractTest
{
    /** @var ReceiptDbRepository|MockObject */
    private $receiptDbRepository;
    /** @var ChainRepository|MockObject */
    private $chainRepository;
    /** @var ActiveChainItemsStrategy */
    private $strategy;

    public function setUp()
    {
        $this->receiptDbRepository = $this->createMock(ReceiptDbRepository::class);
        $this->chainRepository = $this->createMock(ChainRepository::class);
        $this->strategy = new VerifiedChainsStrategy($this->receiptDbRepository, $this->chainRepository);
    }

    /** @test */
    public function getReceiptIds()
    {
        $this->chainRepository->expects($this->once())->method('getIdsVerifiedWithLimit')->willReturn([1]);
        $this->receiptDbRepository->expects($this->once())->method('getIdsByStatusAndChainIds')->willReturn([2]);

        $result = $this->strategy->getReceiptIds(10);
        $this->assertEquals([2], $result->getData());
        $this->assertEquals(false, $result->getFinished());
    }

    /** @test */
    public function getReceiptIdsNoReceipts()
    {
        $this->chainRepository->expects($this->once())->method('getIdsVerifiedWithLimit')->willReturn([1]);
        $this->receiptDbRepository->expects($this->once())->method('getIdsByStatusAndChainIds')->willReturn([]);

        $result = $this->strategy->getReceiptIds(10);
        $this->assertEquals([], $result->getData());
        $this->assertEquals(false, $result->getFinished());
    }

    /** @test */
    public function getReceiptIdsFinished()
    {
        $this->chainRepository->expects($this->once())->method('getIdsVerifiedWithLimit')->willReturn([]);

        $result = $this->strategy->getReceiptIds(10);
        $this->assertEquals([], $result->getData());
        $this->assertEquals(true, $result->getFinished());
    }
}
