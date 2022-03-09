<?php

namespace App\Controller\Front_Office;
use App\Entity\Hebergement;
use App\Form\HebergementType;
use App\Repository\HebergementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Data\SearchData;
use App\Form\SearchForm;
class HomeController extends AbstractController
{
    /**
     * @Route("/front-office/home", name="Front-home")
     */
    public function index(HebergementRepository $repository, Request $request ): Response
    {
        
        $data = new SearchData();
        $data->page = $request->get('page', 1);
       // $hebergement=$repository->findAll();
       $hebergement = $repository->findSearch($data);

        return $this->render('Front_Office/Home.html.twig', 
            ['hebergement'=>$hebergement]
        );
    }

}

