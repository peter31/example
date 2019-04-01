<?php declare(strict_types=1);

namespace Geo\Application\UseCase\City;

use Geo\Application\Port\CityRepositoryInterface;
use Geo\Domain\Model\City;
use Geo\Domain\ValueObject\CityId;

class GetCityById
{
    /** @var CityRepositoryInterface */
    private $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param CityId $id
     *
     * @return City|null
     */
    public function execute(CityId $id): ?City
    {
        return $this->cityRepository->findCityById($id);
    }
}
