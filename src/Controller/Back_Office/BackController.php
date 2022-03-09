<?php

namespace App\Controller\Back_Office;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/back-office", name="back")
     */
    public function index(): Response
    {
        return $this->render('Back_Office/Dashboard.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
}
