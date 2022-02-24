<?php

namespace App\Controller\Front_Office;

use App\Entity\Hebergement;
use App\Form\HebergementType;
use App\Repository\TypeHebergementType;
use App\Repository\HebergementRepository;
use App\Repository\TypeHebergementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class HebergementUserController extends AbstractController
{
    /**
     * @Route("/front-office/hebergement/user", name="hebergement_user")
     */
    public function index(): Response
    {
        return $this->render('Front_Office/hebergement/index.html.twig', [
            'controller_name' => 'HebergementUserController',
        ]);
    }

    /**
     * @param HebergementRepository $repository
     * @param TypeHebergementRepository $typeHebergementRepository
     * @return Response
     * @Route ("/front-office/hebergement/list", name="ListHebergementFront")
     */
    public function listHebergement (HebergementRepository $repository,TypeHebergementRepository $typeHebergementRepository){
        $hebergement=$repository->findAll();
        $types=$typeHebergementRepository->findAll();
        $em=$this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('count(e.id)');
        $qb->from(Hebergement::class,'e');

        $count = $qb->getQuery()->getSingleScalarResult();
        return $this->render('/Front_Office/hebergement/listHebergementFront.html.twig',['hebergement'=>$hebergement,'length'=>$count,'types'=>$types]);
    }


    /**
     * @param Request $request
     * @return Response
     * @Route ("/front-office/hebergement/add",name="AddHebergementUtilisateur")
     */
    public function addHebergementUtilisateur (Request $request )
    {
        $hebergement = new Hebergement();
        $form =$this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $ImageProp= $hebergement->getImghbrg();
            $ImageName = md5(uniqid()).'.'.$ImageProp->guessExtension();
            $ImageProp->move(
                $this->getParameter('hebergements_directory'),
                $ImageName
            );
            $hebergement->setImgHbrg($ImageName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($hebergement);
            $em->flush();
            return $this->redirectToRoute('ListHebergementUtilisateur');
        }
        return $this->render('Front_Office/hebergement/addHebergementUtilisateurForm.html.twig',
            ['formHebergement'=>$form->createView()]);

    }


    
        /**
     * @param $id
     * @param HebergementRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/front-office/hebergement/detail/{id}",name="DetailHebergementFRONT")
     */
    function detail($id,HebergementRepository $repository){
        $hebergement=$repository->find($id);
        return $this->render('/Front_Office/hebergement/HebergementDetailFront.html.twig',['hebergement'=>$hebergement]);

    }



   /**
     * @Route("/front-office/hebergement/all",name="hebergementRechercheType")
     */

    public function Recherche(Request $request)
    {
        $search = $request->query->get('hebergment');
        $em = $this->getDoctrine()->getManager();
        $hebergement = $em->getRepository(hebergement::class)->findType($search);

        return $this->render('/Front_Office/hebergement/listHebergementFront.html.twig',['hebergement'=>$hebergement]);
    }

}