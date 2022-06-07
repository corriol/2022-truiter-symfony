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
use Symfony\Component\Validator\Constraints\Date;
use WW\Faker\Provider\Picture;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class AppFixtures extends Fixture
{

    public Generator $faker;
    public UserPasswordHasherInterface $hasher;
    public ContainerBagInterface $params;

    public function __construct(UserPasswordHasherInterface  $hasher, ContainerBagInterface $params)
    {
        $this->faker = Factory::create('ca_ES');
        $this->faker->addProvider(new Picture($this->faker));
        $this->hasher = $hasher;
        $this->params = $params;
    }

    public function load(ObjectManager $manager): void
    {


        for ($i=0; $i<10; $i++)
            $this->faker->picture('resources', 1920, 1080);

        $profileDir = $this->params->get('app.user.profile.dir');
        $users = [];
        $user = new User();
        $user->setName("user");
        $user->setUsername("user");
        $user->setPassword($this->hasher->hashPassword($user, "user"));

        $user->setProfile($this->faker->picture($profileDir, 400, 400, false));
        // 400x400
        // 135x135
        // 40x40

        $manager->persist($user);

        $users[] = $user;
        for ($i=0; $i<10; $i++) {
            $user = new User();
            $user->setName($this->faker->name);
            $user->setUsername(($this->faker->userName));
            $user->setPassword($this->hasher->hashPassword($user, "user"));
            $user->setProfile($this->faker->picture($profileDir, 400, 400, false));

            $manager->persist($user);
            $users[] = $user;
        }

        foreach($users as $user) {
            for ($i=0; $i<rand(0,10); $i++) {
                $user->addFollowing($users[array_rand($users)]);
            }
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
