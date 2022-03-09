<?php

namespace App\Controller\Front_Office;
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
     * @Route("/", name="app_front_office_commentaire")
     */
    public function index(): Response
    {
        return $this->render('front_office/commentaire/index.html.twig', [
            'controller_name' => 'commentaireController',
        ]);
    }

   
  
    /**
     * @Route("/front-office/commentaire/listall" , name="listall_commentaire")
     */

    public function listall(Request $request)
     { 
        $commentaires= $this->getDoctrine()->getRepository(commentaire::class)->findAll();
        return  $this->render('Front_Office/commentaire/list.html.twig',['commentaires' => $commentaires]);
    }
    
    /**
     * @Route("/front-office/commentaire/list" , name="list_commentaire")
     */

    public function list(Request $request)
     { 
        $commentaires= $this->getDoctrine()->getRepository(Commentaire::class)->findAll();
        return  $this->render('Front_Office/commentaire/list.html.twig',['commentaires' => $commentaires]);
    }

    /**
     * @Route("/front-office/commentaire/listD" , name="listD_commentaire")
     */

    public function listD(Request $request)
     { 
        $commentaires= $this->getDoctrine()->getRepository(Commentaire::class)->findAllorder();
        return  $this->render('Front_Office/commentaire/list.html.twig',['commentaires' => $commentaires]);
    }


    /**
     * @Route("/front-office/blog/list" , name="listes_blog")
    */

    public function listAlls(Request $request)
    {
        //rÃŠcupÃŠrer tous les blogs de la table blog de la BD
        // et les mettre dans le tableau $blogs
        $blogs= $this->getDoctrine()->getRepository(Blog::class)->findAll();
        return  $this->render('Front_Office/blog/list.html.twig',['blogs' => $blogs]);
    }



    /**
     * @Route("/front-office/commentaire/lists/{id}" , name="lists_commentaire")
     * Method({"GET", "POST"})
     */

    public function new(Request $request, $id) {
     //   $g=$this->getDoctrine()->getRepository(Blog::class)->find($id);
        $i = $this->getDoctrine()->getRepository(Blog::class)->find($id);
        $i->setNbvue($i->getNbvue()+1);
        $this->getDoctrine()->getManager()->flush();
       // $i = $this->getDoctrine()->getRepository(Blog::class)->updateNbvu($id,($i->getNbvue($i))+1);
        $commentaire = new commentaire();
        $commentairelist = $this->getDoctrine()->getRepository(Commentaire::class)->findComment($i);
        $form ="";
        $form = $this->createForm(commentaireType::class,$commentaire);
        $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid() && $form-> isRequired()) {
        $commentaire = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $commentaire->setBlog($i);
        $commentaire->setDateComment();
        $entityManager->persist($commentaire);
        $entityManager->flush();
        return $this->redirectToRoute('listes_blog');
       // return $this->render('Front_Office/commentaire/lists.html.twig',['form' => $form->createView(),'i' => $i,'commentairelist' =>$commentairelist]);
   
    }
    return $this->render('Front_Office/commentaire/lists.html.twig',['form' => $form->createView(),'i' => $i,'commentairelist' =>$commentairelist]);
}
     
   
    /**
     * @Route("/front-office/commentaire/detaille/{id}", name="detaille_commentaire")
     */
    public function detaille($id) {
        $i = $this->getDoctrine()->getRepository(commentaire::class)->find($id);

        return $this->render('Front_Office/commentaire/detaille.html.twig', array('i' => $i));
    }


    /**
     * @Route("/front-office/commentaire/modifier/{id}", name="modifier_commentaire")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        
        $commentaire = new commentaire();
        $commentaire = $this->getDoctrine()->getRepository(commentaire::class)->find($id);

        $form = $this->createFormBuilder($commentaire)
        ->add('Nom', TextType::class)
        ->add('code', NumberType::class)
        ->add('facebookPage', TextType::class)
        ->add('instagramPage', TextType::class)
            ->add('save', SubmitType::class, array(
                    'label' => 'Modifier')
            )->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $form-> isRequired()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('list_commentaire');
        }
        
        return $this->render('Front_Office/commentaire/modifier.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/front-office/commentaire/supprimer/{id}",name="supprimer_commentaire")
     * @Method({"DELETE"})
     */
    public function delete(commentaire $commentaire) {
        $id=$commentaire->getId();
        $entitymanager=$this->getDoctrine()->getManager();
        $entitymanager->remove($commentaire);
        $entitymanager->flush(); 
        return $this->redirectToRoute('list_commentaire');
      
    }

/**
 * @Route("/front-office/commentaire/pdf" , name="commentaire_pdf")
 */

public function pdf(CommentaireRepository $CommentaireRepository)
{
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');

    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $commentaires= $CommentaireRepository->findAll();
    // Retrieve the HTML generated in our twig file
    $html=$this->renderView('Front_Office/commentaire/pdf.html.twig',['commentaires' => $commentaires]);

    // Load HTML to Dompdf
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser (force download)
    $dompdf->stream("mypdf.pdf", [
        "Attachment" => true
    ]);
}

}
