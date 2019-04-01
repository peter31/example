<?php declare(strict_types=1);

namespace Geo\Application\Query\City;

class CityListFilterQuery
{
    /** @var string */
    private $name;

    /** @var int */
    private $province;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'province' => $this->province
        ];
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $province
     */
    public function setProvince(int $province): void
    {
        $this->province = $province;
    }
}
