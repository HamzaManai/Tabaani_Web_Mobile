<?php

namespace App\Controller\Back_Office;
use App\Entity\BlogSearch;
use App\Form\BlogSearchType;
use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
