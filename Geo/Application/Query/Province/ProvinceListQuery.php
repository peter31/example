<?php declare(strict_types=1);

namespace Geo\Application\Query\Province;

class ProvinceListQuery
{
    /** @var string */
    private $sort = 'id';

    /** @var string */
    private $sort_type = 'desc';

    /** @var ProvinceListFilterQuery */
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
     * @return ProvinceListQuery
     */
    public function setSort(string $sort): self
    {
        $this->sort = $sort;

        return $this;
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
     * @return ProvinceListQuery
     */
    public function setSortType(string $sort_type): self
    {
        $this->sort_type = $sort_type;

        return $this;
    }

    /**
     * @return ProvinceListFilterQuery
     */
    public function getFilters(): ProvinceListFilterQuery
    {
        if (!($this->filters instanceof ProvinceListFilterQuery)) {
            $this->filters = new ProvinceListFilterQuery();
        }

        return $this->filters;
    }

    /**
     * @param ProvinceListFilterQuery $filters
     * @return ProvinceListQuery
     */
    public function setFilters(ProvinceListFilterQuery $filters): self
    {
        $this->filters = $filters;

        return $this;
    }
}
