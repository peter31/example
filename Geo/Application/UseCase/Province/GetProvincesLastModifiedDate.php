<?php declare(strict_types=1);

namespace Geo\Application\UseCase\Province;

use Geo\Application\Port\ProvinceRepositoryInterface;

class GetProvincesLastModifiedDate
{
    /** @var ProvinceRepositoryInterface */
    protected $repository;

    /**
     * GetCitiesLastModifiedDate constructor.
     *
     * @param ProvinceRepositoryInterface $repository
     */
    public function __construct(ProvinceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): ?\DateTime
    {
        return $this->repository->getLastModifiedDate();
    }
}
