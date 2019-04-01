<?php declare(strict_types=1);

namespace Geo\Adapter\Port;

use Doctrine\ORM\EntityManagerInterface;
use Geo\Adapter\Doctrine\StateDbRepository;
use Geo\Application\Exception\PageNotFoundException;
use Geo\Application\Model\CollectionModel;
use Geo\Application\Model\PaginatorModel;
use Geo\Application\Port\StateRepositoryInterface;
use Geo\Application\Query\State\StateListFilterQuery;
use Geo\Application\Query\State\StateListQuery;
use Geo\Application\Query\State\StatePaginatedListQuery;
use Geo\Domain\Model\State;
use Geo\Domain\ValueObject\StateId;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;

class StateRepository implements StateRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $em;
    /** @var StateDbRepository */
    private $stateDbRepository;

    public function __construct(
        EntityManagerInterface $em,
        StateDbRepository $stateDbRepository
    ) {
        $this->em = $em;
        $this->stateDbRepository = $stateDbRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatePaginatedList(StatePaginatedListQuery $query): PaginatorModel
    {
        try {
            $paginator = $this->stateDbRepository->paginateStates(
                $this->normalize($query->getFilters()),
                [$query->getSort() => $query->getSortType()],
                $query->getPage(),
                $query->getLimit()
            );

            /** @var \ArrayIterator $currentPageResults */
            $currentPageResults = $paginator->getCurrentPageResults();
            return new PaginatorModel(
                $currentPageResults->getArrayCopy(),
                $paginator->getCurrentPage(),
                $paginator->getNbPages()
            );
        } catch (OutOfRangeCurrentPageException $ex) {
            throw new PageNotFoundException();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStateList(StateListQuery $query): CollectionModel
    {
        return new CollectionModel(
            $this->stateDbRepository->findStatesBy(
                $this->normalize($query->getFilters()),
                [$query->getSort() => $query->getSortType()]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findStateById(StateId $id): ?State
    {
        return $this->stateDbRepository->find($id->value());
    }

    /**
     * {@inheritdoc}
     */
    public function updateState(State $state): void
    {
        $this->em->persist($state);
        $this->em->flush($state);
    }

    /**
     * @param StateListFilterQuery $filter
     * @return array
     */
    private function normalize(StateListFilterQuery $filter): array
    {
        return $filter->toArray();
    }
}
