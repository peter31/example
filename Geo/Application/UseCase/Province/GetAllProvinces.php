<?php declare(strict_types=1);

namespace Geo\Application\UseCase\Province;

use Geo\Application\Port\ProvinceRepositoryInterface;
use Geo\Application\ViewModel\ProvinceViewRawModel;

class GetAllProvinces
{
    /** @var ProvinceRepositoryInterface */
    protected $repository;

    public function __construct(ProvinceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        $raw = $this->repository->findAllRaw();
        $result = array_map(
            function (array $data) {
                return new ProvinceViewRawModel($data);
            },
            $raw
        );

        return $result;
    }
}
