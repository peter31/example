<?php declare(strict_types=1);

namespace Geo\Application\UseCase\Province;

use Geo\Application\Model\CollectionModel;
use Geo\Application\Query\Province\ProvinceListQuery;
use Geo\Application\Port\ProvinceRepositoryInterface;

class GetProvinceList
{
    /** @var ProvinceRepositoryInterface */
    private $provinceRepository;

    public function __construct(ProvinceRepositoryInterface $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * @param ProvinceListQuery $query
     *
     * @return CollectionModel
     */
    public function execute(ProvinceListQuery $query): CollectionModel
    {
        return $this->provinceRepository->getProvinceList($query);
    }
}
