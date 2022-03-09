<?php

namespace App\Controller\Front_Office;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/front-office", name="home")
     */
    public function index(): Response
    {
        return $this->render('Front_Office/Home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}

