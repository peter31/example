<?php declare(strict_types=1);

namespace Geo\Application\ViewModel;

class PaginationViewModel
{
    /** @var int */
    private $total = 0;
    /** @var int */
    private $current = 0;

    public function __construct(int $total, int $current)
    {
        $this->total = $total;
        $this->current = $current;
    }
}
