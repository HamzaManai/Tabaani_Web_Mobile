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
use App\Data\SearchData;
use App\Form\SearchForm;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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
    public function listHebergement(HebergementRepository $repository, Request $request)
    {
        // $hebergement=$repository->findAll();

        $data = new SearchData();
        $data->page = $request->get('page', 1);

        $formSearch = $this->createForm(SearchForm::class, $data);
        $formSearch->handleRequest($request);

        $hebergement = $repository->findSearch($data);
        return $this->render(
            '/Back_Office/hebergement/listHebergement.html.twig',
            [
                'hebergement' => $hebergement,
                'formSearch' => $formSearch->createView()
            ]
        );
    }





    /**
     * @param $id
     * @param HebergementRepository $repository
     * @Route ("/back-office/hebergement/DeleteHebergement/{id}",name="DeleteHebergement")
     */
    function deleteHebergement($id, HebergementRepository  $repository)
    {
        $em = $this->getDoctrine()->getManager();
        $hebergement = $repository->find($id);
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
    function detail($id, HebergementRepository $repository)
    {
        $hebergement = $repository->find($id);
        return $this->render('/Back_Office/hebergement/HebergementDetailBack.html.twig', ['hebergement' => $hebergement]);
    }




    /**
     * @param Request $request
     * @return Response
     * @Route ("/back-office/hebergement/add",name="AddHebergement")
     */
    public function addHebergement(Request $request)
    {
        $hebergement = new Hebergement();
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->add('Proprietaire', EntityType::class, [
            'class' => Proprietaire::class,
            'choice_label' => 'nom_prop',
            'multiple' => false,
            'placeholder' => 'Choisissez un proprietaire'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ImageProp = $hebergement->getImghbrg();
            $ImageName = md5(uniqid()) . '.' . $ImageProp->guessExtension();
            $ImageProp->move(
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
            $em->persist($hebergement);
            $em->flush();
            return $this->redirectToRoute('ListHebergement');
        }
        return $this->render(
            'Back_Office/hebergement/addHebergementForm.html.twig',
            ['formHebergement' => $form->createView()]
        );
    }



    /**
     * @param $id
     * @param HebergementRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/back-office/hebergement/UpdateHebergement/{id}",name="UpdateHeberg")
     */
    function update($id, HebergementRepository $repository, Request $request)
    {

        $hebergement = $repository->find($id);
        $form = $this->createForm(HebergementType::class, $hebergement);

        $form->add('Proprietaire', EntityType::class, [
            'class' => Proprietaire::class,
            'choice_label' => 'nom_prop',
            'multiple' => false,
            'placeholder' => 'Choisissez un proprietaire'
        ]);
        /*
        $oldFileName = $hebergement->getImgHbrg();
        $oldFileNamePath = $this->get('kernel')->getRootDir().'/../uploads/hebergements/'.$hebergement->getImgHbrg();
        $pictureFile = new File($oldFileNamePath);
        $hebergement->setPicture($pictureFile );
 */
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
            return $this->redirectToRoute('ListHebergement');
        }
        return $this->render(
            'Back_Office/Hebergement/EditHebergementForm.html.twig',
            ['formHebergement' => $form->createView(), 'id' => $id]
        );
    }



    /**
     * @Route("/back-office/hebergement/delete/image/{id}", name="hebergement_delete_image", methods={"DELETE"})
     */
    public function deleteImage(ImagesHebergement $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);


        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {

            $nom = $image->getNomImg();

            unlink($this->getParameter('hebergements_directory') . '/' . $nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    /**
     * @Route("/exportcsv", name="listHebergementsCSV", options={"expose"=true}, methods={"GET","POST"})
     *
     **/
    public function exportcsv(NormalizerInterface $normalizer)
    {
        //$sessionuser = $this->session->get('user');
        //$user = $this->finduser($sessionuser);
        //search all the datas of type Object
        $datas = $this->getDoctrine()->getRepository(hebergement::class)->findAll();
        // normalization and encoding of $datas
        $encoders = [new CsvEncoder()];
        $normalizers = array(new ObjectNormalizer());

        $json = $normalizer->normalize($datas, 'json', ['groups' => ['post:read']]);

        $serializer = new Serializer($normalizers, $encoders);
        $csvContent = $serializer->serialize($json, 'csv');

        $response = new Response($csvContent);
        $response->headers->set('Content-Encoding', 'UTF-8');
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename=ListHebergement.csv');
        return $response;
    }




    /**
     * @Route("/back-office/hebergement/list/pdf", name="listHebergementsPDF", methods={"GET"})
     */
    public function listHebergementsPDF(HebergementRepository $hebergement)
    {
        // Configure Dompdf according to your needs
        $pdfoptions = new Options();
        $pdfoptions->set('defaultFont', 'Arial');
        $pdfoptions->set('isRemoteEnabled', TRUE);
        $pdfoptions->set('tempDir', '/uploads/hebergements');
        // $pdfoptions->set('tempDir','.\www\DaryGym\public\uploads\images');


        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfoptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Back_Office/Hebergement/listHebergementPDF.html.twig', [
            'hebergement' => $hebergement->findAll(),
        ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("ListHebergement.pdf", [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/back-office/hebergement/list/Excel", name="listHebergementsExcel", methods={"GET"})
     */
    public function listHebergementsEXCEL(HebergementRepository $hebergement)
    {
        $hebergement = $hebergement->findAll();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //$sheet->setCellValue('A1', $hebergement->findAll());
        $sheet->fromArray([$hebergement], NULL, 'A1');

        $writer = new Writer\Xls($spreadsheet);

        $response =  new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="ListHebergement.xls"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }


















    /* Mobile */ 

    










}
