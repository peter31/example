<?php declare(strict_types=1);

namespace Geo\Application\Query\Province;

class ProvincePaginatedListQuery
{
    /** @var int */
    private $page = 1;

    /** @var int */
    private $limit = 10;

    /** @var string */
    private $sort = 'id';

    /** @var string */
    private $sort_type = 'desc';

    /** @var ProvinceListFilterQuery */
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
     * @return ProvincePaginatedListQuery
     */
    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
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
     * @return ProvincePaginatedListQuery
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
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
     * @return ProvincePaginatedListQuery
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
     * @return ProvincePaginatedListQuery
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
     * @return ProvincePaginatedListQuery
     */
    public function setFilters(ProvinceListFilterQuery $filters): self
    {
        $this->filters = $filters;

        return $this;
    }
}
