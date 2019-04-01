<?php declare(strict_types=1);

namespace Geo\Application\UseCase\Province;

use Geo\Application\Exception\PageNotFoundException;
use Geo\Application\Model\PaginatorModel;
use Geo\Application\Query\Province\ProvincePaginatedListQuery;
use Geo\Application\Port\ProvinceRepositoryInterface;

class GetProvincePaginatedList
{
    /** @var ProvinceRepositoryInterface */
    private $provinceRepository;

    public function __construct(ProvinceRepositoryInterface $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * @param ProvincePaginatedListQuery $query
     *
     * @return PaginatorModel
     * @throws PageNotFoundException
     */
    public function execute(ProvincePaginatedListQuery $query): PaginatorModel
    {
        return $this->provinceRepository->getProvincePaginatedList($query);
    }
}
