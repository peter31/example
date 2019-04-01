<?php declare(strict_types=1);

namespace Geo\Application\UseCase\City;

use Geo\Application\Exception\PageNotFoundException;
use Geo\Application\Model\PaginatorModel;
use Geo\Application\Query\City\CityPaginatedListQuery;
use Geo\Application\Port\CityRepositoryInterface;

class GetCityPaginatedList
{
    /** @var CityRepositoryInterface */
    private $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param CityPaginatedListQuery $query
     *
     * @return PaginatorModel
     * @throws PageNotFoundException
     */
    public function execute(CityPaginatedListQuery $query): PaginatorModel
    {
        return $this->cityRepository->getCityPaginatedList($query);
    }
}
