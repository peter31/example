<?php declare(strict_types=1);

namespace Geo\Application\ViewModel;

use Geo\Domain\Model\State;

class StateViewModel
{
    /** @var State */
    private $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }
}
