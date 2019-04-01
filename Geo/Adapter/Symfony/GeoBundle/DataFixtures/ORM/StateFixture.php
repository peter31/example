<?php

declare(strict_types=1);

namespace Geo\Adapter\Symfony\GeoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Geo\Domain\Model\State;

class StateFixture extends AbstractFixture
{
    public const REFERENCE = 'state';

    /** @var Factory */
    private $faker;

    /**
     * StateFixture constructor.
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
        for ($index = 1; $index <= 9; $index++) {
            $state = new State();
            $state->setName($this->faker->state);
            $state->setAbbr(sprintf('%s%s', substr($state->getName(), 1, 1), $index));

            $manager->persist($state);

            $this->addReference(sprintf('%s_%s', self::REFERENCE, $index), $state);
        }

        $manager->flush();
    }
}
