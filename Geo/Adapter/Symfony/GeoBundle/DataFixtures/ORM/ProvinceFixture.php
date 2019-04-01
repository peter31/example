<?php

declare(strict_types=1);

namespace Geo\Adapter\Symfony\GeoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Geo\Domain\Model\Province;

class ProvinceFixture extends AbstractFixture
{
    public const REFERENCE = 'province';

    /** @var Factory */
    private $faker;

    /**
     * ProvinceFixture constructor.
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
        for ($index = 1; $index <= 5; $index++) {
            $province = new Province();
            $province->setName($this->faker->state);
            $province->setSlug(sprintf('%s_%s', $province->getName(), $index));

            $manager->persist($province);

            $this->addReference(sprintf('%s_%s', self::REFERENCE, $index), $province);
        }

        $manager->flush();
    }
}
