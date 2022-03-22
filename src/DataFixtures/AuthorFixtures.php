<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AuthorFixtures extends Fixture {

    public const REFERENCE = 'AUTHORS_REFERENCE';

    private Generator $faker;

    public function __construct() {

        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    : void {

        for ($i = 0; $i < 10; $i++) {
            $manager->persist(
                $this->getFakeAuthor()
            );
        }

        $referenceAuthor = $this->getFakeAuthor();
        $this->addReference(self::REFERENCE, $referenceAuthor);

        $manager->persist($referenceAuthor);
        $manager->flush();
    }

    private function getFakeAuthor()
    : Author {

        return new Author(
            $this->faker->name(),
            $this->faker->dateTime(),
            $this->faker->sentences(4, true)
        );
    }
}