<?php declare(strict_types=1);

namespace Geo\Domain\Model;

class Province
{
    /** @var int */
    protected $id;
    /** @var string */
    protected $name;
    /** @var string */
    protected $slug;
    /** @var bool */
    protected $isDeleted = false;
    /** @var \DateTime */
    protected $updatedAt;
    /** @var mixed */
    protected $cities;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $slug
     *
     * @return self
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     */
    public function setIsDeleted(bool $isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @param City $city
     *
     * @return self
     */
    public function addCity(City $city): self
    {
        $this->cities[] = $city;
        $city->setProvince($this);

        return $this;
    }

    /**
     * Get cities
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * @return int
     */
    public function getCitiesCount(): int
    {
        return count($this->getCities());
    }
}
