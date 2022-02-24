<?php

namespace App\Controller\Back_Office;

use App\Entity\Hebergement;
use App\Entity\ImagesHebergement;
use App\Repository\HebergementRepository;
use App\Form\HebergementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Proprietaire;

class HebergementController extends AbstractController
{
    /**
     * @Route("/back-office/hebergement", name="hebergement")
     */
    public function index(): Response
    {
        return $this->render('Back_Office/hebergement/index.html.twig', [
            'controller_name' => 'HebergementController',
        ]);
    }



    /**
     * @param HebergementRepository $repository
     * @return Response
     * @Route ("/back-office/hebergement/list", name="ListHebergement")
     */
    public function listHebergement (HebergementRepository $repository ){
        $hebergement=$repository->findAll();
        return $this->render('/Back_Office/hebergement/listHebergement.html.twig',['hebergement'=>$hebergement]);
    }





    /**
     * @param $id
     * @param HebergementRepository $repository
     * @Route ("/back-office/hebergement/DeleteHebergement/{id}",name="DeleteHebergement")
     */
    function deleteHebergement($id,HebergementRepository  $repository){
        $em=$this->getDoctrine()->getManager();
        $hebergement=$repository->find($id);
        $em->remove($hebergement);
        $em->flush();
        return $this->redirectToRoute('ListHebergement');
    }


   
        /**
     * @param $id
     * @param HebergementRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/back-office/hebergement/detail/{id}",name="DetailHebergementBack")
     */
    function detail($id,HebergementRepository $repository){
        $hebergement=$repository->find($id);
        return $this->render('/Back_Office/hebergement/HebergementDetailBack.html.twig',['hebergement'=>$hebergement]);

    }




    /**
     * @param Request $request
     * @return Response
     * @Route ("/back-office/hebergement/add",name="AddHebergement")
     */
    public function addHebergement (Request $request )
    {
        $hebergement = new Hebergement();
        $form =$this->createForm(HebergementType::class, $hebergement);
        $form->add('Proprietaire', EntityType::class, [
            'class' => Proprietaire::class,
            'choice_label' => 'nom_prop',
            'multiple' => false, 
            'placeholder' => 'Choisissez un proprietaire'
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $ImageProp= $hebergement->getImghbrg();
            $ImageName = md5(uniqid()).'.'.$ImageProp->guessExtension();
            $ImageProp->move(
                $this->getParameter('hebergements_directory'),
                $ImageName
            );

            
            $hebergement->setImgHbrg($ImageName);
           
        
            $images = $form->get('images_hebergement')->getData();
    
            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('hebergements_directory'),
                    $fichier
                );
                
                // On crée l'image dans la base de données
                $img = new ImagesHebergement();
                $img->setNomImg($fichier);
                $hebergement->addImagesHebergement($img);
            }


            $em=$this->getDoctrine()->getManager();
            $em->persist($hebergement);
            $em->flush();
            return $this->redirectToRoute('ListHebergement');
        }
        return $this->render('Back_Office/hebergement/addHebergementForm.html.twig',
            ['formHebergement'=>$form->createView()]);

    }



        /**
     * @param $id
     * @param HebergementRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/back-office/hebergement/UpdateHebergement/{id}",name="UpdateHeberg")
     */
    function update($id,HebergementRepository $repository,Request $request){
        $hebergement=$repository->find($id);
        $form=$this->createForm(HebergementType::class,$hebergement);

        $form->add('Proprietaire', EntityType::class, [
            'class' => Proprietaire::class,
            'choice_label' => 'nom_prop',
            'multiple' => false, 
            'placeholder' => 'Choisissez un proprietaire'
        ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $ImageHbrg= $hebergement->getImgHbrg();
            $ImageName = md5(uniqid()).'.'.$ImageHbrg->guessExtension();
            $ImageHbrg->move(
                $this->getParameter('hebergements_directory'),
                $ImageName
            );

            
            $hebergement->setImgHbrg($ImageName);

      $images = $form->get('images_hebergement')->getData();
    
            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('hebergements_directory'),
                    $fichier
                );
                
                // On crée l'image dans la base de données
                $img = new ImagesHebergement();
                $img->setNomImg($fichier);
                $hebergement->addImagesHebergement($img);
            }

            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ListHebergement');
        }
        return $this->render('Back_Office/Hebergement/EditHebergementForm.html.twig',
            ['formHebergement'=>$form->createView()]);
    }



/**
 * @Route("/hebergement/delete/image/{id}", name="hebergement_delete_image", methods={"DELETE"})
 */
public function deleteImage(ImagesHebergement $image, Request $request){
    $data = json_decode($request->getContent(), true);

    // On vérifie si le token est valide
    if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
        // On récupère le nom de l'image
        $nom = $image->getNomImg();
        // On supprime le fichier
        unlink($this->getParameter('images_directory').'/'.$nom);

        // On supprime l'entrée de la base
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();

        // On répond en json
        return new JsonResponse(['success' => 1]);
    }else{
        return new JsonResponse(['error' => 'Token Invalide'], 400);
    }
}






}
