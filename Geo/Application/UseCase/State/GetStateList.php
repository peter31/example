<?php declare(strict_types=1);

namespace Geo\Application\UseCase\State;

use Geo\Application\Model\CollectionModel;
use Geo\Application\Model\PaginatorModel;
use Geo\Application\Port\StateRepositoryInterface;
use Geo\Application\Query\State\StateListQuery;

class GetStateList
{
    /** @var StateRepositoryInterface */
    private $stateRepository;

    public function __construct(StateRepositoryInterface $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    /**
     * @param StateListQuery $query
     *
     * @return CollectionModel
     */
    public function execute(StateListQuery $query): CollectionModel
    {
        return $this->stateRepository->getStateList($query);
    }
}
