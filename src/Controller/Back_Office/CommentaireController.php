<?php

namespace App\Controller\Back_Office;
use App\Form\CommentaireType;
use App\Entity\CommentaireSearch;
use App\Form\CommentaireSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class CommentaireController extends AbstractController
{
    
    /**
     * @Route("/", name="app_back_office_commentaire")
     */
    public function index(): Response
    {
        return $this->render('back-office/commentaire/index.html.twig', [
            'controller_name' => 'commentaireController',
        ]);
    }
  
 
    /**
    *@Route("/back-office/commentaire/recherche",name="recherche_commentaire")
    */
    public function recherche(Request $request)
    {  $commentaires=[];
      $commentaire = new Commentaire();
     // $blog = $this->getDoctrine()->getRepository(Commentaire::class)->find($id);
      $form = $this->createFormBuilder($commentaire)
      ->add('nom', TextType::class)
      ->add('mail', TextType::class)
      ->add('comment', TextType::class)
      ->add('id', TextType::class)
      ->getForm();
      $form->handleRequest($request);
      if($form->isSubmitted()) {
        $nom = $commentaire->getNom();   
        $id = $commentaire->getId();
        $mail = $commentaire->getMail();
        $comment = $commentaire->getComment();
      //  $cratedate = $commentaire->getCreateat();
      if (($nom!="") ||($id!="") ||($mail!="")|| ($comment!=""))
      $commentaires= $this->getDoctrine()->getRepository(Commentaire::class)->findEntitiesBycode( $nom,$id,$comment,$mail);
      else   
       $commentaires= $this->getDoctrine()->getRepository(Commentaire::class)->findAll();
     }
      return  $this->render('Back_Office/commentaire/recherche.html.twig',[ 'form' =>$form->createView(), 'commentaires' => $commentaires]);  
    }
   
    /**
     * @Route("/back-office/commentaire/detailles/{id}", name="detailles_commentaire")
     */
    public function detaille($id) {
        $i = $this->getDoctrine()->getRepository(commentaire::class)->find($id);

        return $this->render('Back_Office/commentaire/detailles.html.twig', array('i' => $i));
    }

    /**
     * @Route("/back-office/commentaire/clist" , name="clist_commentaire")
     */

    public function clists(Request $request)
     { 
        $commentaires= $this->getDoctrine()->getRepository(Commentaire::class)->findAll();
        return  $this->render('Back_Office/commentaire/lists.html.twig',['commentaires' => $commentaires]);
    }
    /**
     * @Route("/back-office/commentaire/listsd" , name="listsd_commentaire")
     */

    public function listsd(Request $request)
     { 
        $commentaires= $this->getDoctrine()->getRepository(Commentaire::class)->findAllorder();
        return  $this->render('Back_Office/commentaire/lists.html.twig',['commentaires' => $commentaires]);
    }

    /**
     * @Route("/back-office/commentaire/supprime/{id}",name="supprime_commentaire")
     * @Method({"DELETE"})
     */
    public function supprimer(commentaire $commentaire) {
        $id=$commentaire->getId();
        $entitymanager=$this->getDoctrine()->getManager();
        $entitymanager->remove($commentaire);
        $entitymanager->flush(); 
        return $this->redirectToRoute('lists_commentaire');
      
    }
  
}
