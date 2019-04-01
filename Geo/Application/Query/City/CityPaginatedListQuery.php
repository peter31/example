<?php declare(strict_types=1);

namespace Geo\Application\Query\City;

class CityPaginatedListQuery
{
    /** @var int */
    private $page = 1;
    /** @var int */
    private $limit = 10;
    /** @var string */
    private $sort = 'id';
    /** @var string */
    private $sort_type = 'desc';
    /** @var int */
    private $province;
    /** @var CityListFilterQuery */
    private $filters;

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return string
     */
    public function getSort(): string
    {
        return $this->sort;
    }

    /**
     * @param string $sort
     */
    public function setSort(string $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getSortType(): string
    {
        return $this->sort_type;
    }

    /**
     * @param string $sort_type
     */
    public function setSortType(string $sort_type): void
    {
        $this->sort_type = $sort_type;
    }

    /**
     * @return int|null
     */
    public function getProvince(): ?int
    {
        return $this->province;
    }

    /**
     * @param int $province
     */
    public function setProvince(int $province): void
    {
        $this->province = $province;
    }

    /**
     * @return CityListFilterQuery
     */
    public function getFilters(): CityListFilterQuery
    {
        if (!($this->filters instanceof CityListFilterQuery)) {
            $this->filters = new CityListFilterQuery();
        }

        return $this->filters;
    }

    /**
     * @param CityListFilterQuery $filters
     */
    public function setFilters(CityListFilterQuery $filters): void
    {
        $this->filters = $filters;
    }
}
