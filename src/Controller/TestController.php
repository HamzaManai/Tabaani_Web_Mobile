<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/testadmin", name="test_admin")
     */
    public function testadmin(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @IsGranted("ROLE_INFLUENCER")
     * @Route("/testinfluencer", name="test_influencer")
     */
    public function testinfluencer(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/testuser", name="test_testuser")
     */
    public function testuser(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }



}
