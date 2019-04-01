<?php declare(strict_types=1);

namespace Geo\Application\Query\Province;

class ProvinceListFilterQuery
{
    /** @var string */
    private $name;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        if ($this->name) {
            $array['name'] = $this->name;
        }

        return $array;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ProvinceListFilterQuery
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
