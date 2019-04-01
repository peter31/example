<?php declare(strict_types=1);

namespace Geo\Application\ViewModel;

use Geo\Domain\Model\Province;

class ProvinceViewModel
{
    /** @var Province */
    private $province;

    public function __construct(Province $province)
    {
        $this->province = $province;
    }
}
