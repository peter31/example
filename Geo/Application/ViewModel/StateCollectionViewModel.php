<?php declare(strict_types=1);

namespace Geo\Application\ViewModel;

class StateCollectionViewModel
{
    /** @var array */
    private $states = [];
    /** @var PaginationViewModel */
    private $pagination;

    public function __construct(array $states = [], int $total = 0, int $current = 0)
    {
        $this->states = $states;
        $this->pagination = new PaginationViewModel($total, $current);
    }
}
