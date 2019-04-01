<?php declare(strict_types=1);

namespace Geo\Application\UseCase\City;

use Geo\Application\Port\CityRepositoryInterface;

class GetCitiesLastModifiedDate
{
    /** @var CityRepositoryInterface */
    protected $repository;

    /**
     * GetCitiesLastModifiedDate constructor.
     *
     * @param CityRepositoryInterface $repository
     */
    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): ?\DateTime
    {
        return $this->repository->getLastModifiedDate();
    }
}
