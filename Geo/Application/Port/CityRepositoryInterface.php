<?php declare(strict_types=1);

namespace Geo\Application\Port;

use Geo\Application\Exception\PageNotFoundException;
use Geo\Application\Model\CollectionModel;
use Geo\Application\Model\PaginatorModel;
use Geo\Application\Query\City\CityListQuery;
use Geo\Application\Query\City\CityPaginatedListQuery;
use Geo\Application\ViewModel\CityCollectionViewModel;
use Geo\Domain\Model\City;
use Geo\Domain\ValueObject\CityId;

interface CityRepositoryInterface
{
    /**
     * @param CityPaginatedListQuery $query
     *
     * @return PaginatorModel
     * @throws PageNotFoundException
     */
    public function getCityPaginatedList(CityPaginatedListQuery $query): PaginatorModel;

    /**
     * @param CityListQuery $query
     *
     * @return CollectionModel
     */
    public function getCityList(CityListQuery $query): CollectionModel;

    /**
     * @param CityId $id
     *
     * @return City|null
     */
    public function findCityById(CityId $id): ?City;

    /**
     * @param City $city
     */
    public function updateCity(City $city): void;

    public function getLastModifiedDate(): ?\DateTime;

    public function findAllRaw(): array;
}
