<?php

namespace App\UseCase\FollowUserUseCase;

use App\Entity\User;
use App\Exception\UserCannotFollowHimselfException;
use function PHPUnit\Framework\throwException;

class FollowUserUseCase
{

    /**
     * @throws UserCannotFollowHimselfException
     */
    public function __construct(User $user, User $userTarget)
    {
        throw new UserCannotFollowHimselfException();
        //if ($user === $userTarget)


    }
}