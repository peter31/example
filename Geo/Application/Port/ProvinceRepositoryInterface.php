<?php declare(strict_types=1);

namespace Geo\Application\Port;

use Geo\Application\Exception\PageNotFoundException;
use Geo\Application\Model\CollectionModel;
use Geo\Application\Model\PaginatorModel;
use Geo\Application\Query\Province\ProvinceListQuery;
use Geo\Application\Query\Province\ProvincePaginatedListQuery;
use Geo\Domain\Model\Province;
use Geo\Domain\ValueObject\ProvinceId;

interface ProvinceRepositoryInterface
{
    /**
     * @param ProvincePaginatedListQuery $query
     *
     * @return PaginatorModel
     * @throws PageNotFoundException
     */
    public function getProvincePaginatedList(ProvincePaginatedListQuery $query): PaginatorModel;

    /**
     * @param ProvinceListQuery $query
     *
     * @return CollectionModel
     */
    public function getProvinceList(ProvinceListQuery $query): CollectionModel;

    /**
     * @param ProvinceId $id
     *
     * @return Province|null
     */
    public function findProvinceById(ProvinceId $id): ?Province;

    /**
     * @param Province $province
     */
    public function updateProvince(Province $province): void;

    public function getLastModifiedDate(): ?\DateTime;

    public function findAllRaw(): array;
}
