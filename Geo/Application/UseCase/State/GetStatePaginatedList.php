<?php declare(strict_types=1);

namespace Geo\Application\UseCase\State;

use Geo\Application\Exception\PageNotFoundException;
use Geo\Application\Model\PaginatorModel;
use Geo\Application\Port\StateRepositoryInterface;
use Geo\Application\Query\State\StatePaginatedListQuery;

class GetStatePaginatedList
{
    /** @var StateRepositoryInterface */
    private $stateRepository;

    public function __construct(StateRepositoryInterface $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    /**
     * @param StatePaginatedListQuery $query
     *
     * @return PaginatorModel
     * @throws PageNotFoundException
     */
    public function execute(StatePaginatedListQuery $query): PaginatorModel
    {
        return $this->stateRepository->getStatePaginatedList($query);
    }
}
