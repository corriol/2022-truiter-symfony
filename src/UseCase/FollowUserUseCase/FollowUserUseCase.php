<?php

namespace App\UseCase\FollowUserUseCase;

use App\Entity\User;
use App\Exception\UserCannotFollowAUserTwiceException;
use App\Exception\UserCannotFollowHimselfException;

class FollowUserUseCase
{

    private User $user;
    private User $userTarget;
    /**
     * @throws UserCannotFollowHimselfException
     * @throws UserCannotFollowAUserTwiceException
     */
    public function __construct(User $user, User $userTarget)
    {
        $this->user = $user;
        $this->userTarget = $userTarget;

        if ($user == $userTarget) {
            throw new UserCannotFollowHimselfException();
        }

        if ($user->getFollowing()->contains($userTarget))
            throw new UserCannotFollowAUserTwiceException();
    }

    public function execute(): User {
        $this->user->addFollowing($this->userTarget);
        return $this->user;
    }


}