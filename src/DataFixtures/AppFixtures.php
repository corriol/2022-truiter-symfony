<?php

namespace App\DataFixtures;

use App\Entity\Tweet;
use DateTime;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {

        for ($i=0; $i<20; $i++) {
            $tweet = new Tweet();
            $tweet->setText($this->faker->realText(140));
            $tweet->setCreatedAt($this->faker->dateTimeBetween('-1 month'));
            $manager->persist($tweet);
        }
        $manager->flush();
    }
}
