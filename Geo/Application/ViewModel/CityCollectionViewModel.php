<?php declare(strict_types=1);

namespace Geo\Application\ViewModel;

class CityCollectionViewModel
{
    /** @var array */
    private $cities = [];
    /** @var PaginationViewModel */
    private $pagination;

    public function __construct(array $cities = [], int $total = 0, int $current = 0)
    {
        $this->cities = $cities;
        $this->pagination = new PaginationViewModel($total, $current);
    }
}
