<?php

namespace Geo\Adapter\Symfony\GeoBundle\DataFixtures\Reporting;

use Geo\Domain\Model\City;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class CityFixture
 * @package Geo\Adapter\Symfony\GeoBundle\DataFixtures\Reporting
 */
class CityFixture extends AbstractFixture implements DependentFixtureInterface
{
    const REF = 'city';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 9; $i++) {
            $province = $this->getReference(ProvinceFixture::REF . '-' . ($i % 3));

            $city = new City();
            $city
                ->setProvince($province)
                ->setName('City ' . $i)
            ;

            $manager->persist($city);
            $this->addReference(self::REF . '-' . $i, $city);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProvinceFixture::class,
        ];
    }
}
