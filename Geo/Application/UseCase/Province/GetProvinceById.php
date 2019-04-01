<?php declare(strict_types=1);

namespace Geo\Application\UseCase\Province;

use Geo\Application\Port\ProvinceRepositoryInterface;
use Geo\Domain\Model\Province;
use Geo\Domain\ValueObject\ProvinceId;

class GetProvinceById
{
    /** @var ProvinceRepositoryInterface */
    private $provinceRepository;

    public function __construct(ProvinceRepositoryInterface $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * @param ProvinceId $id
     *
     * @return Province|null
     */
    public function execute(ProvinceId $id): ?Province
    {
        return $this->provinceRepository->findProvinceById($id);
    }
}
