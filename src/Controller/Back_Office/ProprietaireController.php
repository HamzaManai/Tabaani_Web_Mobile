<?php

namespace App\Controller\Back_Office;

use App\Entity\Proprietaire;
use App\Form\ProprietaireType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProprietaireRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProprietaireController extends AbstractController
{
    /**
     * @Route("/back-office/proprietaire", name="proprietaire")
     */
    public function index(): Response
    {
        return $this->render('Back_office/proprietaire/index.html.twig', [
            'controller_name' => 'ProprietaireController',
        ]);
    }

    /**
     * @param ProprietaireRepository $repository
     * @return Response
     * @Route ("/back-office/proprietaire/list", name="ListProprietaire")
     */
    public function listTProprietaire (ProprietaireRepository $repository ){
        $proprietaire=$repository->findAll();
        return $this->render('/Back_Office/proprietaire/listProprietaire.html.twig',['proprietaire'=>$proprietaire]);
    }


    /**
     * @param $id
     * @param ProprietaireRepository $repository
     * @Route ("/back-office/proprietaire/DeleteProprietaire/{id}",name="DeleteProprietaire")
     */
    function deleteProprietaire($id,ProprietaireRepository  $repository){
        $em=$this->getDoctrine()->getManager();
        $proprietaire=$repository->find($id);
        $em->remove($proprietaire);
        $em->flush();
        return $this->redirectToRoute('ListProprietaire');
    }





    /**
     * @param Request $request
     * @return Response
     * @Route ("/back-office/proprietaire/add",name="AddProprietaire")
     */
    public function addProprietaire (Request $request )
    {
        $proprietaire = new Proprietaire();
        $form =$this->createForm(ProprietaireType::class, $proprietaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $ImageProp= $proprietaire->getImgProp();
            $ImageName = md5(uniqid()).'.'.$ImageProp->guessExtension();
            $ImageProp->move(
                $this->getParameter('proprietaires_directory'),
                $ImageName
            );

            
            $proprietaire->setImgProp($ImageName);


            $em=$this->getDoctrine()->getManager();
            $em->persist($proprietaire);
            $em->flush();
            return $this->redirectToRoute('ListProprietaire');
        }
        return $this->render('Back_Office/proprietaire/addProprietaireForm.html.twig',
            ['formProprietaire'=>$form->createView()]);

    }



        /**
     * @param $id
     * @param ProprietaireRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/back-office/proprietaire/UpdateProprietaire/{id}",name="UpdateProp")
     */
    function update($id,ProprietaireRepository $repository,Request $request){
        $proprietaire=$repository->find($id);
        $form=$this->createForm(ProprietaireType::class,$proprietaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $ImageProp= $proprietaire->getImgProp();
            $ImageName = md5(uniqid()).'.'.$ImageProp->guessExtension();
            $ImageProp->move(
                $this->getParameter('proprietaires_directory'),
                $ImageName
            );

            
            $proprietaire->setImgProp($ImageName);


            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ListProprietaire');
        }
        return $this->render('Back_Office/Proprietaire/EditProprietaireForm.html.twig',
            ['formProprietaire'=>$form->createView()]);
    }






    
}
