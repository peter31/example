<?php declare(strict_types=1);

namespace Receipt\Tests\Application\StatusFix;

use Receipt\Application\StatusFix\StatusFixStrategiesManager;
use Receipt\Application\StatusFix\Strategy\StatusFixStrategyInterface;
use Snapcart\TestBundle\Controller\AbstractTest;

/**
 * bin/phpunit -c tests src/Receipt/Tests/Application/StatusFix/StatusFixStrategiesManagerTest.php
 */
class StatusFixStrategiesManagerTest extends AbstractTest
{
    /** @test */
    public function getStrategyByNameSuccess()
    {
        $strategy = $this->createMock(StatusFixStrategyInterface::class);
        $strategy->expects($this->once())->method('getName')->willReturn('test');

        $manager = new StatusFixStrategiesManager([$strategy]);
        $this->assertEquals($strategy, $manager->getStrategyByName('test'));
    }

    /** @test */
    public function getStrategyByNameError()
    {
        $this->expectException(\InvalidArgumentException::class);

        $manager = new StatusFixStrategiesManager([]);
        $manager->getStrategyByName('test');
    }

    /** @test */
    public function getStrategyByNameError2()
    {
        $this->expectException(\InvalidArgumentException::class);

        $strategy = $this->createMock(StatusFixStrategyInterface::class);
        $strategy->expects($this->once())->method('getName')->willReturn('test');

        $manager = new StatusFixStrategiesManager([$strategy]);
        $manager->getStrategyByName('some_other_name');
    }
}
