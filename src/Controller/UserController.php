<?php

namespace App\Controller;

use App\Repository\TweetRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/{username}", name="app_user")
     */
    public function index(string $username, TweetRepository $tweetRepository,
    UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(["username"=>$username]);
        if (empty($user))
            $this->createNotFoundException("L'usuari $username no existeix!");

        $tuits = $tweetRepository->findBy(["user"=>$user], ["createdAt"=>"DESC"]);

        return $this->render('user/index.html.twig', [
            'truits' => $tuits,
            'user'=> $user
        ]);
    }

    /**
     * @Route("/settings/profile", name="app_settings_profile")
     */
    public function profile(): Response {
        return new Response("It works!");
    }
}
