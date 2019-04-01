<?php declare(strict_types=1);

namespace Geo\Adapter\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Geo\Domain\Model\State;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

class StateDbRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, State::class);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int $page
     * @param int $max
     * @param bool $useOutputWalkers
     * @return Pagerfanta
     */
    public function paginateStates(array $criteria = [], array $orderBy = [], ?int $page = 1, ?int $limit = 10): Pagerfanta
    {
        $qb = $this->createQueryBuilder('o');

        $this->applyCiteria($qb, $criteria);
        $this->applySorting($qb, $orderBy);

        $paginator = new Pagerfanta(new DoctrineORMAdapter($qb, true, false));
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    public function findStatesBy(array $criteria = [], array $orderBy = [], $limit = null, $offset = null)
    {
        $qb = $this->createQueryBuilder('o');

        $this->applyCiteria($qb, $criteria);
        $this->applySorting($qb, $orderBy);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        if (null !== $offset) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }

    private function applyCiteria(QueryBuilder $qb, array $criteria): void
    {
        foreach ($criteria as $property => $value) {
            if (null !== $value) {
                $qb->andWhere(sprintf('o.%s = :%s', $property, $property))
                    ->setParameter($property, $value);
            }
        }
    }

    private function applySorting(QueryBuilder $qb, array $orderBy): void
    {
        foreach ($orderBy as $property => $direction) {
            $qb->addOrderBy(sprintf('o.%s', $property), $direction);
        }
    }
}
