<?php declare(strict_types=1);

namespace Geo\Application\ViewModel;

class CityViewRawModel
{
    public $id;
    public $name;
    public $slug;
    public $province;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->slug = $data['slug'] ?? null;
        $this->province = $data['province'] ?? [];
    }
}
