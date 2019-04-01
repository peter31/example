<?php declare(strict_types=1);

namespace Geo\Application\ViewModel;

use Geo\Domain\Model\City;

class CityViewModel
{
    /** @var City */
    private $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }
}
