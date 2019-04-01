<?php declare(strict_types=1);

namespace Geo\Application\UseCase\City;

use Geo\Domain\Model\City;
use Geo\Application\Command\City\CreateCityCommand;
use Geo\Application\Port\CityRepositoryInterface;
use Geo\Application\UseCase\Province\GetProvinceById;
use Geo\Domain\ValueObject\CityId;
use Geo\Domain\ValueObject\ProvinceId;

class CreateCity
{
    /** @var GetProvinceById */
    private $getProvinceById;
    /** @var CityRepositoryInterface */
    private $cityRepository;

    public function __construct(
        GetProvinceById $getProvinceById,
        CityRepositoryInterface $cityRepository
    ) {
        $this->getProvinceById = $getProvinceById;
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param CreateCityCommand $command
     *
     * @return CityId
     */
    public function execute(CreateCityCommand $command): CityId
    {
        $city = new City();
        $city->setName($command->name);
        $city->setProvince(
            $this->getProvinceById->execute(ProvinceId::existing($command->province))
        );

        $this->cityRepository->updateCity($city);

        return CityId::existing($city->getId());
    }
}
