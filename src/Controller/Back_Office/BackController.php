<?php

namespace App\Controller\Back_Office;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\BlogSearch;
use App\Form\BlogSearchType;
use App\Entity\Blog;
use App\Repository\BlogRepository;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
