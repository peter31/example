<?php declare(strict_types=1);

namespace Geo\Domain\ValueObject;

class StateId
{
    /** @var int */
    private $id;

    public static function existing(int $id): self
    {
        return new self($id);
    }

    private function __construct(int $id)
    {
        $this->id = $id;
    }

    public function value(): int
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}
