<?php declare(strict_types=1);

namespace Geo\Adapter\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Geo\Domain\Model\Province;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProvinceDbRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Province::class);
    }
}
