<?php

namespace App\Controller\Front_Office;
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
use Dompdf\Dompdf;
use Dompdf\Options;
use FontLib\EOT\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class BlogController extends AbstractController
{
   
    /**
     * @Route("/", name="app_back_office_blog")
     */
    public function index(): Response
    {
        return $this->render('front_office/blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }


    /**
     * @Route("/front-office/blog/list" , name="list_blog")
    */

    public function listAll(Request $request,\Swift_Mailer $mailer)
    {
        //rÃŠcupÃŠrer tous les blogs de la table blog de la BD
        // et les mettre dans le tableau $blogs
        $blogs= $this->getDoctrine()->getRepository(Blog::class)->findAll();

        return  $this->render('Front_Office/blog/list.html.twig',['blogs' => $blogs]);
    }

      
    /**
     * @Route("/front-office/blog/detaille/{id}", name="detaille_blog")
     */
    public function detaille($id ) {
        $i = $this->getDoctrine()->getRepository(Blog::class)->find($id);


        return $this->render('Front_Office/blog/detaille.html.twig', array('i' => $i));
    }
    /**
     * @Route("/front-office/blog/supprimer/{id}",name="supprimer_blog")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $Blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Blog);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('list_blog');
    }

  
    /**
     * @Route("/front-office/blog/ajouter" , name="ajouter_blog")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) 
    {
      $Blog = new Blog();
      $form = $this->createForm(BlogType::class,$Blog);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid() && $form-> isRequired())
       {
        $path = $this->getParameter('kernel.project_dir').'/public/Front-Office/img/photo';
        $Blog = $form->getData();
        $file = $form->get('image')->getData();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $entityManager = $this->getDoctrine()->getManager();
        $file->move($path, $fileName);
        $Blog->setImage($fileName);
        $Blog->setCreateat();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Blog);
        $entityManager->flush();
        return $this->redirectToRoute('list_blog');
        }
      return $this->render('Front_Office/blog/ajouter.html.twig',['form' => $form->createView()]);
      }
     
  /**
    *@Route("/front-office/blog/brecherche",name="brecherche_blog")
    */
    public function brecherche(Request $request)
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
      return  $this->render('Front_Office/blog/brecherche.html.twig',[ 'form' =>$form->createView(), 'blogs' => $blogs]);  
    }
   /**
     * @Route("/front-office/blog/modifier/{id}", name="modifier_blog")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {

      $Blog = new Blog();
      $Blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
      $g=$Blog->getImage();
      $form = $this->createFormBuilder($Blog)
          ->add('Nom', TextType::class)
          ->add('Image', FileType::class, array('data_class' => null))
          ->add('Description', TextType::class)
          ->add('Type', TextType::class)
          ->add('save', SubmitType::class, array(
                  'label' => 'Modifier')
          )->getForm();

      $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $form-> isRequired()) {
          $path = $this->getParameter('kernel.project_dir').'/public/Front-Office/img/photo';
          $file = $form->get('Image')->getData();
          $fileName = md5(uniqid()).'.'.$file->guessExtension();
          $entityManager = $this->getDoctrine()->getManager();
          $file->move($path, $fileName);
          $Blog->setImage($fileName);
          $entityManager->flush();

          return $this->redirectToRoute('list_blog');
      }

      return $this->render('Front_Office/blog/modifier.html.twig', ['form' => $form->createView()]);
  }


}