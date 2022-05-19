<?php

namespace App\Controller;

use App\Entity\Tweet;
use App\Entity\User;
use App\Form\TweetType;
use App\Repository\TweetRepository;
use DateTime;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, LoggerInterface $logger, TweetRepository $tweetRepository): Response
    {
        $tweets = $tweetRepository->findBy([], ["createdAt" => "desc"]);

        $tweet = new Tweet();
        $tweet->setCreatedAt(new DateTime());

        $form = $this->createForm(TweetType::class, $tweet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $tweetRepository->add($tweet, true);
            $this->addFlash("info", "El tuit s'ha creat amb èxit");

            return $this->redirectToRoute('home');
        }

        return $this->render('default/index.html.twig', [
                'form' => $form->createView(),
                'truits' => $tweets
            ]
        );
    }
}