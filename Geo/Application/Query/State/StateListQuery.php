<?php declare(strict_types=1);

namespace Geo\Application\Query\State;

class StateListQuery
{
    /** @var string */
    private $sort = 'abbr';

    /** @var string */
    private $sort_type = 'asc';

    /** @var StateListFilterQuery */
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
