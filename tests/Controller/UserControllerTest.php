<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testRegisteredUserCanFollowAnotherUser(): void
    {
        $client = static::createClient();

        // User login process
        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('user');
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('POST', '/users/1/following');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'It works!');

    }
}
