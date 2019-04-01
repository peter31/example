<?php declare(strict_types=1);

namespace Geo\Adapter\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Geo\Domain\Model\City;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CityDbRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City::class);
    }
}
