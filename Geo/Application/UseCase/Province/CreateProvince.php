<?php declare(strict_types=1);

namespace Geo\Application\UseCase\Province;

use Geo\Domain\Model\Province;
use Geo\Application\Command\City\CreateCityCommand;
use Geo\Application\Command\Province\CreateProvinceCommand;
use Geo\Application\Port\ProvinceRepositoryInterface;
use Geo\Domain\ValueObject\ProvinceId;

class CreateProvince
{
    /** @var ProvinceRepositoryInterface */
    private $provinceRepository;

    public function __construct(
        ProvinceRepositoryInterface $provinceRepository
    ) {
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * @param CreateProvinceCommand $command
     *
     * @return ProvinceId
     */
    public function execute(CreateProvinceCommand $command): ProvinceId
    {
        $province = new Province();
        $province->setName($command->name);

        $this->provinceRepository->updateProvince($province);

        return ProvinceId::existing($province->getId());
    }
}
