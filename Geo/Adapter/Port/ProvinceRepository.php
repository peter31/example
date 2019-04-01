<?php declare(strict_types=1);

namespace Geo\Adapter\Port;

use Doctrine\ORM\EntityManager;
use Geo\Adapter\Elasticsearch\ProvinceESRepository;
use Geo\Adapter\Doctrine\ProvinceDbRepository;
use Geo\Application\Exception\PageNotFoundException;
use Geo\Application\Model\CollectionModel;
use Geo\Application\Model\PaginatorModel;
use Geo\Application\Port\ProvinceRepositoryInterface;
use Geo\Application\Query\Province\ProvinceListFilterQuery;
use Geo\Application\Query\Province\ProvinceListQuery;
use Geo\Application\Query\Province\ProvincePaginatedListQuery;
use Geo\Domain\Model\Province;
use Geo\Domain\ValueObject\ProvinceId;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;

class ProvinceRepository implements ProvinceRepositoryInterface
{
    /** @var EntityManager */
    private $em;
    /** @var ProvinceDbRepository */
    private $provinceDbRepository;
    /** @var ProvinceESRepository */
    private $provinceESRepository;

    public function __construct(
        EntityManager $em,
        ProvinceDbRepository $provinceDbRepository,
        ProvinceESRepository $provinceESRepository
    ) {
        $this->em = $em;
        $this->provinceDbRepository = $provinceDbRepository;
        $this->provinceESRepository = $provinceESRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getProvincePaginatedList(ProvincePaginatedListQuery $query): PaginatorModel
    {
        try {
            $paginator = $this->provinceESRepository->findPageBy(
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
    public function getProvinceList(ProvinceListQuery $query): CollectionModel
    {
        return new CollectionModel(
            $this->provinceESRepository->findBy(
                $this->normalize($query->getFilters()),
                [$query->getSort() => $query->getSortType()]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findProvinceById(ProvinceId $id): ?Province
    {
        return $this->provinceDbRepository->find($id->value());
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateProvince(Province $province): void
    {
        $this->em->persist($province);
        $this->em->flush($province);
    }

    public function getLastModifiedDate(): ?\DateTime
    {
        return $this->provinceESRepository->getLastModifiedDate();
    }

    public function findAllRaw(): array
    {
        return $this->provinceESRepository->findAllRaw();
    }

    /**
     * @param ProvinceListFilterQuery $filter
     * @return array
     */
    private function normalize(ProvinceListFilterQuery $filter): array
    {
        return $filter->toArray();
    }
}
