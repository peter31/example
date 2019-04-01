<?php declare(strict_types=1);

namespace Geo\Application\ViewModel;

class ProvinceViewRawModel
{
    public $id;
    public $name;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }
}
