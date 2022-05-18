<?php
namespace App\Controller;

use App\Repository\TweetRepository;
use DateTime;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        $name = $request->query->getAlnum("name");
        $missatge = "Error!";

        $logger->info("Algú ha accedit");

        return $this->render('default/index.html.twig', [
            'truits'=>$tweets,
            'message'=>$missatge,
                'name'=>$name
            ]
        );
    }
}