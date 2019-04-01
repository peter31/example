<?php declare(strict_types=1);

namespace Geo\Application\Port;

use Geo\Application\Exception\PageNotFoundException;
use Geo\Application\Model\CollectionModel;
use Geo\Application\Model\PaginatorModel;
use Geo\Application\Query\State\StateListQuery;
use Geo\Application\Query\State\StatePaginatedListQuery;
use Geo\Domain\Model\State;
use Geo\Domain\ValueObject\StateId;

interface StateRepositoryInterface
{
    /**
     * @param StatePaginatedListQuery $query
     *
     * @return PaginatorModel
     * @throws PageNotFoundException
     */
    public function getStatePaginatedList(StatePaginatedListQuery $query): PaginatorModel;

    /**
     * @param StateListQuery $query
     *
     * @return CollectionModel
     */
    public function getStateList(StateListQuery $query): CollectionModel;

    /**
     * @param StateId $id
     *
     * @return State|null
     */
    public function findStateById(StateId $id): ?State;

    /**
     * @param State $state
     */
    public function updateState(State $state): void;
}
