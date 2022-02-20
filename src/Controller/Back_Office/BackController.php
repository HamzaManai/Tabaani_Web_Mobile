<?php

namespace App\Controller\Back_Office;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    /**
     * @Route("/back-office", name="back")
     */
    public function index(): Response
    {
        return $this->render('Back_Office/AdminMain.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
}
