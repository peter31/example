<?php declare(strict_types=1);

namespace Geo\Application\UseCase\City;

use Geo\Application\Port\CityRepositoryInterface;
use Geo\Application\ViewModel\CityViewRawModel;

class GetAllCities
{
    /** @var CityRepositoryInterface */
    protected $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        $raw = $this->repository->findAllRaw();
        $result = array_map(
            function (array $data) {
                return new CityViewRawModel($data);
            },
            $raw
        );

        return $result;
    }
}
