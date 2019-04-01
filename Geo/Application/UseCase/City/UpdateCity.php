<?php declare(strict_types=1);

namespace Geo\Application\UseCase\City;

use Geo\Application\Command\City\UpdateCityCommand;
use Geo\Application\Port\CityRepositoryInterface;
use Geo\Application\UseCase\Province\GetProvinceById;
use Geo\Domain\Model\City;
use Geo\Domain\ValueObject\ProvinceId;

class UpdateCity
{
    /** @var GetProvinceById */
    private $getProvinceById;
    /** @var CityRepositoryInterface */
    private $cityRepository;

    /**
     * @param GetProvinceById $getProvinceById
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(GetProvinceById $getProvinceById, CityRepositoryInterface $cityRepository)
    {
        $this->getProvinceById = $getProvinceById;
        $this->cityRepository = $cityRepository;
    }


    public function execute(City $city, UpdateCityCommand $command): void
    {
        if (null !== $command->name) {
            $city->setName($command->name);
        }

        if (null !== $command->province) {
            $city->setProvince(
                $this->getProvinceById->execute(ProvinceId::existing($command->province))
            );
        }

        $this->cityRepository->updateCity($city);
    }
}
