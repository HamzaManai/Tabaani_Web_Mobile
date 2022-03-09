<?php

namespace App\Controller\Front_Office;

use App\Entity\Hebergement;
use App\Entity\ReservationHebergement;
use App\Form\HebergementType;
use App\Entity\ImagesHebergement;
use App\Repository\TypeHebergementType;
use App\Repository\HebergementRepository;
use App\Repository\ReseverationHebergementRepository;
use App\Repository\TypeHebergementRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\ProprietaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\ReservationHebergementRepository;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;

class HebergementUserController extends AbstractController
{
    /**
     * @Route("/front-office/hebergement/user", name="hebergement_user")
     */
    public function index(): Response
    {
        return $this->render('Front_Office/hebergement/index.html.twig', [
            'controller_name' => 'HebergementUserController',
        ]);
    }

    /**
     * @param HebergementRepository $repository
     * @param TypeHebergementRepository $typeHebergementRepository
     * @return Response
     * @Route ("/front-office/hebergement/list", name="ListHebergementFront")
     */
    public function listHebergement(HebergementRepository $repository, Request $request)
    {


        $data = new SearchData();
        $data->page = $request->get('page', 1);

        $formSearch = $this->createForm(SearchForm::class, $data);
        $formSearch->handleRequest($request);

        $hebergement = $repository->findSearchFront($data);

        /*
        $em=$this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('count(e.id)');
        $qb->from(Hebergement::class,'e');

        $count = $qb->getQuery()->getSingleScalarResult();
        */

        return $this->render(
            '/Front_Office/hebergement/listHebergementFront.html.twig',
            [
                'hebergement' => $hebergement,
                //'length'=>$count,
                'formSearch' => $formSearch->createView()
            ]
        );
    }


    /**
     * @param Request $request
     * @return Response
     * @Route ("/front-office/hebergement/add",name="AddHebergementUtilisateur")
     */
    public function addHebergementUtilisateur(Request $request)
    {
        $hebergement = new Hebergement();
        $form = $this->createForm(HebergementType::class, $hebergement);
        
        $form->add('captchaCode', CaptchaType::class, array(
            'captchaConfig' => 'ExampleCaptchaUserRegistration',
            'constraints' => [
                new ValidCaptcha([
                    'message' => 'Invalid captcha, please try again',
                ]),
            ],
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $ImageProp = $hebergement->getImghbrg();
            $ImageName = md5(uniqid()) . '.' . $ImageProp->guessExtension();
            $ImageProp->move(
                $this->getParameter('hebergements_directory'),
                $ImageName
            );
            $hebergement->setImgHbrg($ImageName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($hebergement);
            $em->flush();
            return $this->redirectToRoute('hebergementUtilisateur');
        }
        return $this->render(
            'Front_Office/hebergement/addHebergementUtilisateurForm.html.twig',
            ['formHebergement' => $form->createView()]
        );
    }



   /**
     * @param $id
     * @param HebergementRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/front-office/hebergement/UpdateHebergement/{id}",name="UpdateHebergementUtilisateur")
     */
    function updateHebergement($id, HebergementRepository $repository, Request $request)
    {

        $hebergement = $repository->find($id);
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->add('captchaCode', CaptchaType::class, array(
            'captchaConfig' => 'ExampleCaptchaUserRegistration',
            'constraints' => [
                new ValidCaptcha([
                    'message' => 'Invalid captcha, please try again',
                ]),
            ],
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $ImageHbrg = $hebergement->getImgHbrg();
            $ImageName = md5(uniqid()) . '.' . $ImageHbrg->guessExtension();
            $ImageHbrg->move(
                $this->getParameter('hebergements_directory'),
                $ImageName
            );


            $hebergement->setImgHbrg($ImageName);

            $images = $form->get('images_hebergement')->getData();

            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

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

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('hebergementUtilisateur');
        }
        return $this->render(
            'Front_Office/hebergement/EditHebergementUtilisateurForm.html.twig',
            ['formHebergement' => $form->createView()]
        );
    }







    /**
     * @param $id
     * @param HebergementRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/front-office/hebergement/detail/{id}",name="DetailHebergementFRONT")
     */
    function detail($id, HebergementRepository $repository)
    {
        $hebergement = $repository->find($id);
        return $this->render('/Front_Office/hebergement/HebergementDetailFront.html.twig', ['hebergement' => $hebergement]);
    }





    /**
     * @Route("/front-office/hebergement/reserver/{id}", name="HebergementReserver") 
     */
    public function hebergement_reserver(Request $request, hebergement $hebergment, UtilisateurRepository $utalisateurRepositorycomposer , \Swift_Mailer $mailer): Response
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $reservation = new ReservationHebergement();
        //$reservation->setDate(new \DateTime);
        //$reservation->setUtilisateur($utalisateurRepository->findOneBy(array('username'=>$this->getUser()->getUsername())));
        $reservation->setHebergement($hebergment);
        $reservation->setNumResrv($hebergment->getNomHbrg() . rand(1, 100));
        //$reservation->getUtilisateur()->getNomUtl());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reservation);
        $hebergment->setNbrPlaceHbrg($hebergment->getNbrPlaceHbrg() - 1);
        $entityManager->flush();

        
        $message = (new \Swift_Message('Reservation Done'))

        ->setFrom('siteforsa@gmail.com') //to be changed
        //$reservation->getUtilisateur()->getEmail()
        ->setTo('manai.hamza@esprit.tn')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'Front_Office/emails/reservation.html.twig',
              //  ['name' => $name]
            ),
            'text/html') ;

                $mailer->send($message);

        return $this->render('/Front_Office/hebergement/HebergementDetailFront.html.twig', ['id' => $hebergment->getId(),'hebergement' => $hebergment]);

        //return $this->redirectToRoute('ListHebergementFront');
    }


    /**
     * @Route("/front-office/hebergement/ReservationDelete/{id}", name="ReservationHebergementDelete") 
     */
    public function hebergement_reserver_delete($id,Request $request,HebergementRepository $Hebergementrepository,ReservationHebergementRepository $ReservationRepo,UtilisateurRepository $utalisateurRepositorycomposer , \Swift_Mailer $mailer): Response
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    
        $em = $this->getDoctrine()->getManager();
        $reservation = $ReservationRepo->find($id);

        $h = $reservation->getHebergement();
    
        $hebergement = $Hebergementrepository->find($h->getId());
        $hebergement->setNbrPlaceHbrg($hebergement->getNbrPlaceHbrg()  + 1);

        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('hebergementUtilisateur');
        /*
        $message = (new \Swift_Message('Reservation Done'))
        ->setFrom('mail to be changed')
        ->setTo($reservation->getUtilisateur()->getEmail())
        ->setBody('Bonjour,
                    Votre nouveau produit a été ajouté avec succès.

                    FORSA YE MAALEM');
                $mailer->send($message);
        */
        
       // return $this->render('', ['id' => $hebergment->getId(),'hebergement' => $hebergment]);
        //return $this->redirectToRoute('ListHebergementFront');
    }



    /*
    Route("/front-office/hebergement/all",name="hebergementRechercheType")
    public function Recherche(Request $request)
    {
        $search = $request->query->get('hebergment');
        $em = $this->getDoctrine()->getManager();
        $hebergement = $em->getRepository(hebergement::class)->findType($search);

        return $this->render('/Front_Office/hebergement/listHebergementFront.html.twig',['hebergement'=>$hebergement]);
    }
    */





    /**
     *@Route("/front-office/hebergement/utilisateur/{id}/info",name="hebergementUtilisateur")

     */
    public function hebergementUtilisateur($id,Request $request,HebergementRepository $Hebergementrepository,ReservationHebergementRepository $Reservation)
    {
        
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /*
        $em = $this->getEntityManager();
        $query= $em->createQuery('SELECT h FROM App\Entity\Hebergement h WHERE h.user_id = :id');
        return $query->getResult();
        */
        //$hebergement=$Hebergementrepository->findAll();
        //$em = $this->getDoctrine()->getManager();
        $hebergement = $Hebergementrepository->findByUser($id);
        $reservation = $Reservation->findByUser($id);
        //dd($hebergement);

        return $this->render('/Front_Office/hebergement/HebergementUtilisateur.html.twig',
        ['hebergement' => $hebergement,
        'reservation' => $reservation]
        );
    }
    



    /**
     * @param HebergementRepository $repository
     * @param TypeHebergementRepository $typeHebergementRepository
     * @return Response
     * @Route ("/front-office/hebergement/list/utilisateur-proprietaire/{id}", name="ListHebergementUtilisateurProp")
     */
    public function listHebergementUtilisateur($id,ProprietaireRepository $PropRepo ,UtilisateurRepository $Utlrepo,HebergementRepository $Hebergementrepository, Request $request)
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $prop = $PropRepo->find($id);
        $user=$Utlrepo->find($id);
        $hebergement = $Hebergementrepository->findByUser($id);
        //dd($hebergement);
        return $this->render('/Front_Office/hebergement/ListHebergementUser-Prop.html.twig', 
                            ['hebergement' => $hebergement
                            ,'user'=>$user ,
                            'proprietaire'=>$prop]);
        /*
        $em=$this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('count(e.id)');
        $qb->from(Hebergement::class,'e');

        $count = $qb->getQuery()->getSingleScalarResult();
        */

    }    


}
