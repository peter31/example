<?php declare(strict_types=1);

namespace Geo\Adapter\Port;

use Doctrine\ORM\EntityManagerInterface;
use Geo\Adapter\Elasticsearch\CityESRepository;
use Geo\Adapter\Doctrine\CityDbRepository;
use Geo\Application\Exception\PageNotFoundException;
use Geo\Application\Model\CollectionModel;
use Geo\Application\Model\PaginatorModel;
use Geo\Application\Query\City\CityListFilterQuery;
use Geo\Application\Query\City\CityListQuery;
use Geo\Application\Query\City\CityPaginatedListQuery;
use Geo\Application\Port\CityRepositoryInterface;
use Geo\Domain\Model\City;
use Geo\Domain\ValueObject\CityId;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;

class CityRepository implements CityRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $em;
    /** @var CityDbRepository */
    private $cityDbRepository;
    /** @var CityESRepository */
    private $cityESRepository;

    public function __construct(
        EntityManagerInterface $em,
        CityDbRepository $cityDbRepository,
        CityESRepository $cityESRepository
    ) {
        $this->em = $em;
        $this->cityDbRepository = $cityDbRepository;
        $this->cityESRepository = $cityESRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getCityPaginatedList(CityPaginatedListQuery $query): PaginatorModel
    {
        try {
            $paginator = $this->cityESRepository->findPageBy(
                $this->normalize($query->getFilters()),
                [$query->getSort() => $query->getSortType()],
                $query->getPage(),
                $query->getLimit()
            );

            return new PaginatorModel(
                $paginator->getCurrentPageResults(),
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
    public function getCityList(CityListQuery $query): CollectionModel
    {
        return new CollectionModel(
            $this->cityESRepository->findBy(
                $this->normalize($query->getFilters()),
                [$query->getSort() => $query->getSortType()]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findCityById(CityId $id): ?City
    {
        return $this->cityDbRepository->find($id->value());
    }

    /**
     * {@inheritdoc}
     */
    public function updateCity(City $city): void
    {
        $this->em->persist($city);
        $this->em->flush($city);
    }

    public function getLastModifiedDate(): ?\DateTime
    {
        return $this->cityESRepository->getLastModifiedDate();
    }

    public function findAllRaw(): array
    {
        return $this->cityESRepository->findAllRaw();
    }

    /**
     * @param CityListFilterQuery $filter
     *
     * @return array
     */
    private function normalize(CityListFilterQuery $filter): array
    {
        return $filter->toArray();
    }
}
