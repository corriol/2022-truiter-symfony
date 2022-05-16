<?php
namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        $tweets = [
            [
                "username"=>"homer",
                "text"=>"Ouch!",
                "name"=>"Homer",
                "createdAt"=>new DateTime(),
            ],
            [
                "username"=>"marge",
                "text"=>"Oh! Homer!",
                "name"=>"Marge Simpson",
                "createdAt"=>new DateTime(),
            ],

        ];

        $missatge = "Error!";

        return $this->render('default/index.html.twig', [
            'truits'=>$tweets,
            'message'=>$missatge
            ]
        );
    }
}