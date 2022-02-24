<?php

namespace App\Controller\Front_Office;
use App\Entity\Hebergement;
use App\Form\HebergementType;
use App\Repository\HebergementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/front-office", name="Front-home")
     */
    public function index(HebergementRepository $repository ): Response
    {
        $hebergement=$repository->findAll();
        return $this->render('Front_Office/Home.html.twig', 
            ['hebergement'=>$hebergement]
        );
    }
}
