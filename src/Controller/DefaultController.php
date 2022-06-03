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
use function Symfony\Component\Translation\t;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, LoggerInterface $logger, TweetRepository $tweetRepository): Response
    {
        $tweets = $tweetRepository->findBy([], ["createdAt" => "desc"]);

        $tweet = new Tweet();
        $form = $this->createForm(TweetType::class, $tweet);

        if (!empty($this->getUser())) {
            $tweet->setCreatedAt(new DateTime());
            $tweet->setUser($this->getUser());

            $form = $this->createForm(TweetType::class, $tweet);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $tweetRepository->add($tweet, true);

                $this->addFlash("info", t("Tweet has been published"));

                return $this->redirectToRoute('home');
            }
        }

        return $this->render('default/index.html.twig', [
                'form' => $form->createView(),
                'truits' => $tweets
            ]
        );
    }
}