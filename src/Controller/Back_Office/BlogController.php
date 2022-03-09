<?php

namespace App\Controller\Back_Office;
use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use App\Entity\BlogSearch;
use App\Form\BlogSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class BlogController extends AbstractController
{
   
    /**
     * @Route("/", name="app_back_office_blog")
     */
    public function index(): Response
    {
        return $this->render('back_office/blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }


    /**
     * @Route("/back-office/blog/list" , name="lists_blog")
    */

    public function listAll(Request $request)
    {
        //rÃŠcupÃŠrer tous les blogs de la table blog de la BD
        // et les mettre dans le tableau $blogs
        $blogs= $this->getDoctrine()->getRepository(Blog::class)->findAll();
        return  $this->render('Back_Office/blog/list.html.twig',['blogs' => $blogs]);
    }

      
    /**
     * @Route("/back-office/blog/detaille/{id}", name="detaille_blog")
     */

        public function detaille($id) {
        $i = $this->getDoctrine()->getRepository(Blog::class)->find($id);

        return $this->render('Back_Office/blog/detaille.html.twig', array('i' => $i));
    }
    /**
     * @Route("/back-office/blog/bdetaille/{id}", name="bdetaille_blog")
     */

    public function bdetaille($id) {
        $i = $this->getDoctrine()->getRepository(Blog::class)->find($id);

        return $this->render('Back_Office/blog/detaille.html.twig', array('i' => $i));
    }
    /**
     * @Route("/back-office/blog/supprimer/{id}",name="bsupprimer_blog")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $Blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Blog);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('lists_blog');
    }

   
/**
    *@Route("/back-office/blog/recherches",name="recherches_blog")
    */
    public function recherches(Request $request)
    {  $blogs=[];
      $blog = new Blog();
     // $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
      $form = $this->createFormBuilder($blog)
      ->add('nom', TextType::class)
      ->add('description', TextType::class)
      ->add('type', TextType::class)
       ->add('id', TextType::class)
      ->getForm();
      $form->handleRequest($request);
      if($form->isSubmitted()) {
        $nom = $blog->getNom();   
        $id = $blog->getId();
        $description = $blog->getDescription();
        $type = $blog->getType();
        $cratedate = $blog->getCreateat();
      if (($nom!="") ||($id!="") ||($description!="")|| ($type!="") || ($cratedate!=""))
      $blogs= $this->getDoctrine()->getRepository(Blog::class)->findEntitiesBycode( $nom,$id,$description,$type);
      else   
       $blogs= $this->getDoctrine()->getRepository(Blog::class)->findAll();
     }
      return  $this->render('Back_Office/blog/recherches.html.twig',[ 'form' =>$form->createView(), 'blogs' => $blogs]);  
    }
  
    
     
}