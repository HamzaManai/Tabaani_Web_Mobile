<?php

namespace App\Controller\Back_Office;

use App\Entity\TypeHebergement;
use App\Repository\TypeHebergementRepository;
use App\Form\TypeHebergementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TypeHebergementController extends AbstractController
{
    /**
     * @Route("/back-office/type/hebergement", name="type_hebergement")
     */
    public function index(): Response
    {
        return $this->render('/Back_Office/type_hebergement/index.html.twig', [
            'controller_name' => 'TypeHebergementController',
        ]);
    }



    /**
     * @param TypeHebergementRepository $repository
     * @return Response
     * @Route ("/back-office/type-hebergement/list", name="ListTypeHebergement")
     */
    public function listTypeHebergement (TypeHebergementRepository $repository ){
        $type_hebergement=$repository->findAll();
        return $this->render('/Back_Office/type_hebergement/listTypeHebergement.html.twig',['type_hebergement'=>$type_hebergement]);
    }




    /**
     * @param $id
     * @param TypeHebergementRepository $repository
     * @Route ("/back-office/type-hebergement/deleteTypeHebergement/{id}",name="DeleteTypeHebergement")
     */
    function deleteTypeHebergement($id,TypeHebergementRepository  $repository){
        $em=$this->getDoctrine()->getManager();
        $type_hebergement=$repository->find($id);
        $em->remove($type_hebergement);
        $em->flush();
        return $this->redirectToRoute('ListTypeHebergement');
    }




    /**
     * @param Request $request
     * @return Response
     * @Route ("/back-office/type-hebergement/add",name="AddTypeHebergement")
     */
    public function addTypeHebergement (Request $request )
    {
        $type_hebergement = new TypeHebergement();
        $form =$this->createForm(TypeHebergementType::class, $type_hebergement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($type_hebergement);
            $em->flush();
            
            return $this->redirectToRoute('ListTypeHebergement');
        }
        return $this->render('Back_Office/type_hebergement/addTypeHebergementForm.html.twig',
            ['formTypeHebergement'=>$form->createView()]);

    }



        /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/back-office/type-hebergement/updateTypeHebergement/{id}",name="updateTHebergement")
     */
    function updateTypeHeberg($id,TypeHebergementRepository $repository,Request $request){
        $type_hebergement=$repository->find($id);
        $form=$this->createForm(TypeHebergementType::class,$type_hebergement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ListTypeHebergement');
        }
        return $this->render('Back_Office/type_hebergement/EditTypeHebergementForm.html.twig',
            ['formTypeHebergement'=>$form->createView()]);
    }



}
