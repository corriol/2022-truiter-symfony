<?php

namespace App\DataFixtures;

use App\Entity\Tweet;
use App\Entity\User;
use DateTime;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public Generator $faker;
    public UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface  $hasher)
    {
        $this->faker = Factory::create('ca_ES');
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $users = [];
        $user = new User();
        $user->setName("user");
        $user->setUsername("user");
        $user->setPassword($this->hasher->hashPassword($user, "user"));
        $manager->persist($user);

        $users[] = $user;
        for ($i=0; $i<3; $i++) {
            $user = new User();
            $user->setName($this->faker->name);
            $user->setUsername(($this->faker->userName));
            $user->setPassword($this->hasher->hashPassword($user, "user"));
            $manager->persist($user);
            $users[] = $user;
        }

        for ($i=0; $i<20; $i++) {
            $tweet = new Tweet();
            $tweet->setText($this->faker->realText(140));
            $tweet->setCreatedAt($this->faker->dateTimeBetween('-1 month'));
            $tweet->setUser($users[array_rand($users)]);
            $manager->persist($tweet);
        }
        $manager->flush();
    }
}
