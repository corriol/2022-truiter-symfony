<?php

namespace App\Tests\UseCase;

use App\Entity\User;
use App\Exception\UserCannotFollowHimselfException;
use App\UseCase\FollowUserUseCase\FollowUserUseCase;
use PHPUnit\Framework\TestCase;

class FollowUserUseCaseTest extends TestCase
{
    public function testCanCreateObjects(): void
    {
        $user = $this->createMock(User::class);
        $userTarget = $this->createMock(User::class);
        $followUserUseCase = new FollowUserUseCase($user, $userTarget);
        $this->assertInstanceOf(FollowUserUseCase::class, $followUserUseCase);
    }

    /**
     * @throws UserCannotFollowHimselfException
     */
    public function testUserCannotFollowHimself(): void {
        $user = $this->createMock(User::class);
        $followUserUseCase = new FollowUserUseCase($user, $user);

        $this->expectException(UserCannotFollowHimselfException::class);
    }



}
