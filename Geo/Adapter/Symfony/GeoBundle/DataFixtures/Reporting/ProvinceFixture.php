<?php

namespace Geo\Adapter\Symfony\GeoBundle\DataFixtures\Reporting;

use Geo\Domain\Model\Province;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ProvinceFixture
 * @package Geo\Adapter\Symfony\GeoBundle\DataFixtures\Reporting
 */
class ProvinceFixture extends AbstractFixture
{
    const REF = 'province';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 9; $i++) {
            $province = new Province();
            $province
                ->setName('Province ' . $i)
            ;

            $manager->persist($province);
            $this->addReference(self::REF . '-' . $i, $province);
        }

        $manager->flush();
    }
}
