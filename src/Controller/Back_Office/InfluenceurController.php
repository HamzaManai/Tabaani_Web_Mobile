<?php

namespace App\Controller\Back_Office;
use App\Form\InfluenceurType;
use App\Entity\InfluenceurSearch;
use App\Form\InfluenceurSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Influenceur;
use App\Repository\InfluenceurRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dompdf\Dompdf;
use Dompdf\Options;
use FontLib\EOT\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class InfluenceurController extends AbstractController
{


    
    /**
     * @Route("/", name="app_back_office_influenceur")
     */
    public function index(): Response
    {
        return $this->render('back_office/influenceur/index.html.twig', [
            'controller_name' => 'InfluenceurController',
        ]);
    }

    /**
    *@Route("/back-office/influenceur/recherche",name="recherche_influenceur")
    */
  public function recherche(Request $request)
  {
    $influenceurSearch = new InfluenceurSearch();
    $form = $this->createForm(InfluenceurSearchType::class,$influenceurSearch);
    $form->handleRequest($request);
    $influenceurs= [];
    $facebookPage  = "";  
    $email  = "";  
      $instagramPage = "";  
      if($form->isSubmitted() && $form->isValid() && $form-> isRequired()) {
        $nom = $influenceurSearch->getNom();   
     $code = $influenceurSearch->getCode();
      $facebookPage = $influenceurSearch->getFacebookPage();
     $instagramPage = $influenceurSearch->getInstagramPage();
     $email = $influenceurSearch->getEmail();
    if (($nom!="") ||($code!="") ||($facebookPage!="")|| ($instagramPage!="") || ($email!=""))
    $influenceurs= $this->getDoctrine()->getRepository(Influenceur::class)->findEntitiesBycode( $nom, $code,$facebookPage,$instagramPage,$email);
    else   
     $influenceurs= $this->getDoctrine()->getRepository(Influenceur::class)->findAll();
   }
    return  $this->render('Back_Office/influenceur/recherche.html.twig',[ 'form' =>$form->createView(), 'influenceurs' => $influenceurs]);  
  }

    
    /**
     * @Route("/back-office/influenceur/list" , name="list_influenceur")
     */

    public function listall(Request $request)
     { 
        $influenceurs= $this->getDoctrine()->getRepository(Influenceur::class)->findAll();
        return  $this->render('Back_Office/influenceur/list.html.twig',['influenceurs' => $influenceurs]);
    }
    
    /**
     * @Route("/back-office/influenceur/ajouter" , name="ajouter_influenceur")
     * Method({"GET", "POST"})
     */

    public function new(Request $request) {
        $Influenceur = new Influenceur();
        $form = $this->createForm(InfluenceurType::class,$Influenceur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $form-> isRequired()) {
        $path = $this->getParameter('kernel.project_dir').'/public/Back-Office/assets/media/users';
        $Influenceur = $form->getData();
        $file = $form->get('avatar')->getData();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
              $entityManager = $this->getDoctrine()->getManager();
        $file->move($path, $fileName);
        $Influenceur->setAvatar($fileName);
        $entityManager->persist($Influenceur);
        $entityManager->flush();
        return $this->redirectToRoute('list_influenceur');
        }
        return $this->render('Back_Office/influenceur/ajouter.html.twig',['form' => $form->createView()]);
    }
       
    /**
     * @Route("/back-office/influenceur/detaille/{id}", name="detaille_influenceur")
     */
    public function detaille($id) {
        $i = $this->getDoctrine()->getRepository(Influenceur::class)->find($id);

        return $this->render('Back_Office/influenceur/detaille.html.twig', array('i' => $i));
    }


    /**
     * @Route("/back-office/influenceur/modifier/{id}", name="modifier_influenceur")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        
        $Influenceur = new Influenceur();
        $Influenceur = $this->getDoctrine()->getRepository(Influenceur::class)->find($id);

        $form = $this->createFormBuilder($Influenceur)
        ->add('Nom', TextType::class)
        ->add('code', NumberType::class)
        ->add('facebookPage', TextType::class)
        ->add('instagramPage', TextType::class)
        ->add('email', TextType::class)
        ->add('avatar', FileType::class, array('data_class' => null))
        ->add('save', SubmitType::class, array(
                    'label' => 'Modifier')
            )->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $form-> isRequired()) {

            $path = $this->getParameter('kernel.project_dir').'/public/Back-Office/assets/media/users';
            $file = $form->get('avatar')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $entityManager = $this->getDoctrine()->getManager();
            $file->move($path, $fileName);
            $Influenceur->setAvatar($fileName);
           $entityManager->flush();

            return $this->redirectToRoute('list_influenceur');
        }
        
        return $this->render('Back_Office/influenceur/modifier.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/back-office/influenceur/supprimer/{id}",name="supprimer_influenceur")
     * @Method({"DELETE"})
     */
    public function delete(Influenceur $Influenceur) {
        $id=$Influenceur->getId();
        $entitymanager=$this->getDoctrine()->getManager();
        $entitymanager->remove($Influenceur);
        $entitymanager->flush(); 
        return $this->redirectToRoute('list_influenceur');
      
 


    }

/**
 * @Route("/back-office/influenceur/pdf" , name="influenceur_pdf")
 */

public function pdf(InfluenceurRepository $InfluenceurRepository)
{
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');

    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $influenceurs= $InfluenceurRepository->findAll();
    // Retrieve the HTML generated in our twig file
    $html=$this->renderView('Back_Office/influenceur/pdf.html.twig',['influenceurs' => $influenceurs]);

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
