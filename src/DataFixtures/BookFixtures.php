<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class BookFixtures extends Fixture implements DependentFixtureInterface {

    private Generator $faker;

    public function __construct() {

        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    : void {

        for ($i = 0; $i < 100; $i++) {
            $manager->persist(
                $this->getFakeBook()
            );
        }
        $manager->flush();
    }

    private function getFakeBook()
    : Book {

        $genres = ['Action', 'Comedy', 'Romance', 'Sci-fi', 'Programming'];

        return new Book(
            $this->faker->sentence(),
            $this->getReference(AuthorFixtures::REFERENCE),
            $this->faker->sentences(5, true),
            $this->faker->year(),
            $this->faker->numberBetween(1, 10),
            $this->faker->numberBetween(10000, 10000000),
            $this->faker->randomElement($genres)
        );
    }

    public function getDependencies()
    : array {

        return [
            AuthorFixtures::class,
        ];
    }
}