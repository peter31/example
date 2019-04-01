<?php declare(strict_types=1);

namespace Geo\Application\UseCase\Province;

use Geo\Application\Command\Province\UpdateProvinceCommand;
use Geo\Application\Port\ProvinceRepositoryInterface;
use Geo\Domain\Model\Province;

class UpdateProvince
{
    /** @var ProvinceRepositoryInterface */
    private $provinceRepository;

    public function __construct(
        ProvinceRepositoryInterface $provinceRepository
    ) {
        $this->provinceRepository = $provinceRepository;
    }

    public function execute(Province $province, UpdateProvinceCommand $command): void
    {
        if (null !== $command->name) {
            $province->setName($command->name);
        }

        $this->provinceRepository->updateProvince($province);
    }
}
