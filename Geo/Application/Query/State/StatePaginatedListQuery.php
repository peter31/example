<?php declare(strict_types=1);

namespace Geo\Application\Query\State;

class StatePaginatedListQuery
{
    /** @var int */
    private $page = 1;

    /** @var int */
    private $limit = 100;

    /** @var string */
    private $sort = 'abbr';

    /** @var string */
    private $sort_type = 'asc';

    /** @var StateListFilterQuery */
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
     * @return StateListFilterQuery
     */
    public function getFilters(): StateListFilterQuery
    {
        if (null === $this->filters) {
            $this->filters = new StateListFilterQuery();
        }

        return $this->filters;
    }

    /**
     * @param StateListFilterQuery $filters
     */
    public function setFilters(StateListFilterQuery $filters): void
    {
        $this->filters = $filters;
    }
}
