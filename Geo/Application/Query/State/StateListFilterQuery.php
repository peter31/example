<?php declare(strict_types=1);

namespace Geo\Application\Query\State;

class StateListFilterQuery
{
    /** @var string */
    private $name;

    /** @var string */
    private $abbr;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'abbr' => $this->abbr,
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAbbr(): string
    {
        return $this->abbr;
    }

    /**
     * @param string $abbr
     */
    public function setAbbr(string $abbr): void
    {
        $this->abbr = $abbr;
    }
}
