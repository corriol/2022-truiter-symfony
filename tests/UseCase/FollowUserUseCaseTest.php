<?php

namespace App\Tests\UseCase;

use App\Entity\User;
use App\Exception\UserCannotFollowAUserTwiceException;
use App\Exception\UserCannotFollowHimselfException;
use App\UseCase\FollowUserUseCase\FollowUserUseCase;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class FollowUserUseCaseTest extends TestCase
{
    /**
     * @throws UserCannotFollowHimselfException
     */
    public function testCanCreateFollowUserInstance(): void
    {
        $user = $this->createPartialMock(User::class, ['getFollowing', 'addFollowing']);
        // creem dos usuaris diferents per comprovar que funciona bé la creació d'objectes.
        $userTarget = $this->createPartialMock(User::class, ['setUsername']);
        $userTarget->method('setUsername')->willReturn($userTarget);

        $collection = $this->createPartialMock(ArrayCollection::class, ['contains', 'toArray']);
        $collection->method("contains")->willReturn(false);
        $collection->method('toArray')->willReturn([]);

        $user->method("getFollowing")->willReturn($collection);
        $user->method("addFollowing")->willReturn($user);

        $followUserUseCase = new FollowUserUseCase($user, $userTarget);
        $this->assertInstanceOf(FollowUserUseCase::class, $followUserUseCase);
    }

    /**
     * @throws UserCannotFollowHimselfException
     */
    public function testUserCannotFollowHimself(): void {
        $this->expectException(UserCannotFollowHimselfException::class);

        $user = $this->createMock(User::class);
        $followUserUseCase = new FollowUserUseCase($user, $user);
    }

    /**
     * @throws UserCannotFollowHimselfException
     */
    public function testUserCanFollowOtherUser(): void
    {
        $user = $this->createPartialMock(User::class, ['addFollowing', 'getFollowing']);
        $userTarget = $this->createPartialMock(User::class, ['setUsername']);
        $userTarget2 = $this->createPartialMock(User::class, ['setUsername']);
        //$userTarget->method('setUsername')->willReturn($userTarget);

        $user->method('addFollowing')->willReturn($user);

        $collection = $this->createPartialMock(ArrayCollection::class, ['contains']);
        $collection->method("contains")->willReturn(false);
        $collection->add($userTarget2);

        $user->method('getFollowing')->willReturn($collection);

        $followUserUseCase = new FollowUserUseCase($user, $userTarget);
        $user = $followUserUseCase->execute();

        $this->assertContains($userTarget, $user->getFollowing());
    }

    /**
     * @throws UserCannotFollowHimselfException
     */
    public function testUserCannotFollowAUserTwice(): void
    {
        $this->expectException(UserCannotFollowAUserTwiceException::class);

        $user = $this->createPartialMock(User::class, ['addFollowing', 'getFollowing']);
        $userTarget = $this->createPartialMock(User::class, ['setUsername']);

        $user->method('addFollowing')->willReturn($user);

        $collection = $this->createPartialMock(ArrayCollection::class, ['contains']);
        $collection->method("contains")->willReturn(true);
        $collection->add($userTarget);

        $user->method('getFollowing')->willReturn($collection);

        $followUserUseCase = new FollowUserUseCase($user, $userTarget);
        $this->assertContains($userTarget, $user->getFollowing());
    }





}
