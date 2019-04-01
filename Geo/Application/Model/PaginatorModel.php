<?php declare(strict_types=1);

namespace Geo\Application\Model;

class PaginatorModel
{
    /** @var array */
    private $data = [];
    /** @var int */
    private $current = 0;
    /** @var int */
    private $total = 0;

    public function __construct(array $data = [], int $current = 0, int $total = 0)
    {
        $this->data = $data;
        $this->current = $current;
        $this->total = $total;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getCurrent(): int
    {
        return $this->current;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
