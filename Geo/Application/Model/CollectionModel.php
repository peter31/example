<?php declare(strict_types=1);

namespace Geo\Application\Model;

class CollectionModel
{
    /** @var array */
    private $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
