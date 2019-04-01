<?php

declare(strict_types=1);

namespace Geo\Adapter\Symfony\GeoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Geo\Domain\Model\City;

class CityFixture extends AbstractFixture implements DependentFixtureInterface
{
    public const REFERENCE = 'city';

    /** @var Factory */
    private $faker;

    /**
     * CityFixture constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create('en_US');
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($index = 1; $index <= 20; $index++) {
            $name = $this->faker->city;
            $city = $this->createCity(
                $name,
                sprintf('%s_%s', $name, $index),
                $this->getReference(sprintf('%s_%s', ProvinceFixture::REFERENCE, rand(1, 5)))
            );

            $manager->persist($city);

            $this->addReference(sprintf('%s_%s', self::REFERENCE, $index), $city);
        }

        $city = $this->createCity(
            'findme',
            'findme_21',
            $this->getReference(sprintf('%s_%s', ProvinceFixture::REFERENCE, 1))
        );
        $manager->persist($city);

        $this->addReference(sprintf('%s_%s', self::REFERENCE, 21), $city);

        $manager->flush();
    }

    private function createCity(string $name, string $slug, $province)
    {
        $city = new City();
        $city->setName($name);
        $city->setSlug($slug);
        $city->setProvince($province);

        return $city;
    }

    public function getDependencies(): array
    {
        return [
            ProvinceFixture::class,
        ];
    }
}
