<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\TweetRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @IsGranted("ROLE_USER")
     */
    public function profile(Request $request, UserRepository $userRepository): Response {

        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->add($user, true);

            $this->addFlash('info', "Els canvis s'han realitzat correctament");
            return $this->redirectToRoute("app_settings_profile");
        }
        return $this->render('user/profile.html.twig',
        [
            'form'=>$form->createView()
        ]);

    }
}
