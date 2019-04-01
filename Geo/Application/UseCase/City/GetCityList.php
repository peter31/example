<?php declare(strict_types=1);

namespace Geo\Application\UseCase\City;

use Geo\Application\Model\CollectionModel;
use Geo\Application\Port\CityRepositoryInterface;
use Geo\Application\Query\City\CityListQuery;

class GetCityList
{
    /** @var CityRepositoryInterface */
    private $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function execute(CityListQuery $query): CollectionModel
    {
        return $this->cityRepository->getCityList($query);
    }
}
