<?php declare(strict_types=1);

namespace Geo\Application\Query\City;

class CityListQuery
{
    /** @var string */
    private $sort = 'id';
    /** @var string */
    private $sort_type = 'desc';
    /** @var CityListFilterQuery */
    private $filters;

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
     * @return CityListFilterQuery
     */
    public function getFilters(): CityListFilterQuery
    {
        if (null === $this->filters) {
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
