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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;



use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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
    public function listTProprietaire (ProprietaireRepository $repository, NormalizerInterface $normalizer){
        $proprietaire=$repository->findAll();
        $json=$normalizer->normalize($proprietaire , 'json' , ['groups'=>['post:read']]);
        return $this->render('/Back_Office/proprietaire/listProprietaire.html.twig',['proprietaire'=>$proprietaire,json_encode($json)]);
        //return new Response(json_encode($json));
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
    public function addProprietaire (Request $request, NormalizerInterface $normalizer )
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
      


        
        /*
        $em=$this->getDoctrine()->getManager();
        $proprietaire->setNomProp($request->get('nom_prop'));
        $proprietaire->setPrenomProp($request->get('prenom_prop'));
        $proprietaire->setEmailProp($request->get('email_prop'));
        $proprietaire->setNumTlfProp($request->get('num_tlf_prop'));
        $em->persist($proprietaire);
        $em->flush();
        $json=$normalizer->normalize($proprietaire , 'json' , ['groups'=>'post:read']);
        return new Response(json_encode($json));

        */
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














/**
 * @param ProduitsRepository $propRepo
 * @param Request $request
 * @return Response
 * @Route("/back-office/proprietaire/list/searchA", name="ajax_search")
 * @Method("GET")
 */
public function search(Request $request, ProprietaireRepository $propRepo,  NormalizerInterface $normalizer)
{
    //$em = $this->getDoctrine()->getManager();
    $requestString = $request->get('q');
    $entities =  $propRepo->SearchA($requestString);
    if(!$entities) {
        //$result['entities']['error'] = "reservation not found";
        return new JsonResponse(["message" => 'Aucun proprietaire existant !']);
    } else {
       // $serializer = new Serializer([new ObjectNormalizer()]);
        $test = $normalizer->normalize($entities, 'json',  ['groups'=>'post:read']);
        //return new JsonResponse($test);
        //$data=new JsonResponse($test);
        //return $this->render('base.html.twig',['R' =>$entities]);
        return new JsonResponse($test);
        // $result['entities'] = $this->getRealEntities($entities);
    }
}

public function getRealEntities($entities){
    foreach ($entities as $entity){
        $realEntities[$entity->getId()] = $entity->getNomProp();
    }
    return $realEntities;
}


}
