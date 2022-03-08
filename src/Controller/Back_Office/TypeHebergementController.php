<?php

namespace App\Controller\Back_Office;

use App\Entity\TypeHebergement;
use App\Repository\TypeHebergementRepository;
use App\Form\TypeHebergementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;


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
    public function listTypeHebergement (TypeHebergementRepository $repository, NormalizerInterface $normalizer ){
        $type_hebergement=$repository->findAll();
        $json=$normalizer->normalize($type_hebergement , 'json' , ['groups'=>['post:read']]);
        
        return $this->render('/Back_Office/type_hebergement/listTypeHebergement.html.twig',
        ['type_hebergement'=>$type_hebergement
        ,json_encode($json)
        ]);
       // return new Response(json_encode($json));
    }




    /**
     * @param $id
     * @param TypeHebergementRepository $repository 
     * @param FlashyNotifier $flashy
     * @Route ("/back-office/type-hebergement/deleteTypeHebergement/{id}",name="DeleteTypeHebergement")
     */
    function deleteTypeHebergement($id,TypeHebergementRepository  $repository, FlashyNotifier $flashy){
        $em=$this->getDoctrine()->getManager();
        $type_hebergement=$repository->find($id);
        $em->remove($type_hebergement);
        $em->flush();
        //$flashy->success('Added succesfully', 'http://your-awesome-link.com');
        $this->addFlash('delete', 'Deleted with success!!');

        return $this->redirectToRoute('ListTypeHebergement');
    }




    /**
     * @param Request $request
     * @return Response
     * @Route ("/back-office/type-hebergement/add",name="AddTypeHebergement")
     */
    public function addTypeHebergement (Request $request, NormalizerInterface $normalizer,FlashyNotifier $flashy  )
    {

        $type_hebergement = new TypeHebergement();
        
        $form =$this->createForm(TypeHebergementType::class, $type_hebergement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($type_hebergement);
            $em->flush();
            $json=$normalizer->normalize($type_hebergement , 'json' , ['groups'=>'post:read']);
            $flashy->success('Added succesfully', 'http://your-awesome-link.com');
            $this->addFlash('add', 'A new type is created!');
    
            return $this->redirectToRoute('ListTypeHebergement');
        }
        return $this->render('Back_Office/type_hebergement/addTypeHebergementForm.html.twig',
            ['formTypeHebergement'=>$form->createView(),
            
            ]);
        

        /*
        $em=$this->getDoctrine()->getManager();
        $type_hebergement->setNomTypeHbrg($request->get('nom_type_hbrg'));
        $em->persist($type_hebergement);
        $em->flush();
        $json=$normalizer->normalize($type_hebergement , 'json' , ['groups'=>'post:read']);
        return new Response(json_encode($json));
        */

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
            $this->addFlash('edit', 'The type is updated!');

            return $this->redirectToRoute('ListTypeHebergement');
        }
        return $this->render('Back_Office/type_hebergement/EditTypeHebergementForm.html.twig',
            ['formTypeHebergement'=>$form->createView()]);
    }





        /* MOBILE  */


/**
 * @param TypeHebergementRepository $repository
 * @return Response
 * @Route ("/mobile/back-office/type-hebergement/list", name="ListTypeHebergementMobile")
 */
public function listTypeHebergementMobile (TypeHebergementRepository $repository, NormalizerInterface $normalizer ){
    $type_hebergement=$repository->findAll();
    $json=$normalizer->normalize($type_hebergement , 'json' , ['groups'=>['post:read']]);
    return new Response(json_encode($json));
}




/**
 * @param $id
 * @param TypeHebergementRepository $repository
 * @Route ("/mobile/back-office/type-hebergement/deleteTypeHebergement/{id}",name="DeleteTypeHebergementMobile")
 */
function deleteTypeHebergementMobile($id,TypeHebergementRepository  $repository, NormalizerInterface $normalizer){
    $em=$this->getDoctrine()->getManager();
    $type_hebergement=$repository->find($id);
    $em->remove($type_hebergement);
    $em->flush();
    $json=$normalizer->normalize($type_hebergement , 'json' , ['groups'=>'post:read']);
    return new Response(json_encode($json));
}




/**
 * @param Request $request
 * @return Response
 * @Route ("/mobile/back-office/type-hebergement/add",name="AddTypeHebergementMobile")
 */
public function addTypeHebergementMobile (Request $request, NormalizerInterface $normalizer  )
{

    $type_hebergement = new TypeHebergement();
    $em=$this->getDoctrine()->getManager();
    $type_hebergement->setNomTypeHbrg($request->get('nom_type_hbrg'));
    $em->persist($type_hebergement);
    $em->flush();
    $json=$normalizer->normalize($type_hebergement , 'json' , ['groups'=>'post:read']);
    return new Response(json_encode($json));
    

}        






}
