<?php declare(strict_types=1);

namespace Geo\Application\ViewModel;

class ProvinceCollectionViewModel
{
    /** @var array */
    private $provinces = [];
    /** @var PaginationViewModel */
    private $pagination;

    public function __construct(array $provinces = [], int $total = 0, int $current = 0)
    {
        $this->provinces = $provinces;
        $this->pagination = new PaginationViewModel($total, $current);
    }
}
