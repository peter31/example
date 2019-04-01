<?php declare(strict_types=1);

namespace Receipt\Tests\Application\StatusFix\Strategy;

use PHPUnit\Framework\MockObject\MockObject;
use Receipt\Adapter\Doctrine\ReceiptDbRepository;
use Receipt\Application\StatusFix\Strategy\NonGroceryChainsStrategy;
use Snapcart\TestBundle\Controller\AbstractTest;

/**
 * bin/phpunit -c tests src/Receipt/Tests/Application/StatusFix/Strategy/NonGroceryChainsStrategyTest.php
 */
class NonGroceryChainsStrategyTest extends AbstractTest
{
    /** @var ReceiptDbRepository|MockObject */
    private $receiptDbRepository;
    /** @var NonGroceryChainsStrategy */
    private $strategy;

    public function setUp()
    {
        $this->receiptDbRepository = $this->createMock(ReceiptDbRepository::class);
        $this->strategy = new NonGroceryChainsStrategy($this->receiptDbRepository);
    }

    /** @test */
    public function getReceiptIds()
    {
        $this->receiptDbRepository->expects($this->once())->method('getIdsByStatusesAndChainWithLabel')->willReturn([2]);

        $result = $this->strategy->getReceiptIds(10);
        $this->assertEquals([2], $result->getData());
        $this->assertEquals(false, $result->getFinished());
    }

    /** @test */
    public function getReceiptIdsNoReceipts()
    {
        $this->receiptDbRepository->expects($this->once())->method('getIdsByStatusesAndChainWithLabel')->willReturn([]);

        $result = $this->strategy->getReceiptIds(10);
        $this->assertEquals([], $result->getData());
        $this->assertEquals(false, $result->getFinished());
    }
}
