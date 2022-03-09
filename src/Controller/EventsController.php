<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\EventsType;
use App\Repository\EventsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/events")
 */
class EventsController extends AbstractController
{
    /**
     * @Route("/", name="events_index", methods={"GET"})
     */
    public function index(EventsRepository $repository): Response
    {
        return $this->render('events/index.html.twig', [
            'events' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="events_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file=$event->getImageevent();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $entityManager=$this->getDoctrine()->getManager();
            try {
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $event->setImageevent($fileName);
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('events_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="events_show", methods={"GET"})
     */
    public function show(Events $event): Response
    {
        return $this->render('events/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="events_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Events $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        /*$imageEvent=$event->getImageevent();
        $ImageName = md5(uniqid()).'.'.$imageEvent->guessExtension();
        $imageEvent->move(
            $this->getParameter('uploads_directory'),
            $ImageName
        );*/

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->flush();

            return $this->redirectToRoute('events_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="events_delete", methods={"POST"})
     */
    public function delete(Request $request, Events $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/tri/triTrending", name="event_Trending")
     */
    public function TriTrending(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT E FROM App\Entity\Events E 
            ORDER BY E.nbr_going DESC'
        );

        $MostSuccesful = $query->getResult();
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->upload();
            $event->setNbrGoing($event->getNbrGoing());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
        }
        $events = $query->getResult();

        return $this->render('events/index.html.twig', [
            'events' => $events,
            'MostSuccesful' => $MostSuccesful,
        ]);

    }

    /**
     * @Route("/tri/triAlphabetical", name="event_triAlphabetical")
     */
    public function TriAlphabetical(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT E FROM App\Entity\Events E 
            ORDER BY E.eventname ASC'
        );

        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->upload();
            $event->setNbrGoing($event->getNbrGoing());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
        }
        $events = $query->getResult();

        return $this->render('events/index.html.twig', [
            'events' => $events,
        ]);

    }

    /**
     * @Route("/tri/triDate", name="event_triDate")
     */
    public function TriDate(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT E FROM App\Entity\Events E 
            ORDER BY E.eventdate ASC '
        );

        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->upload();
            $event->setNbrGoing($event->getNbrGoing());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
        }
        $events = $query->getResult();

        return $this->render('events/index.html.twig', [
            'events' => $events,
        ]);

    }

    /**
     * @Route("/filter/ThisMonth", name="event_ThisMonth")
     */
    public function FilterThisMonth(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT E FROM App\Entity\Events E 
            WHERE DATE_DIFF(E.eventdate,CURRENT_DATE())<30 AND DATE_DIFF(E.eventdate,CURRENT_DATE())>0 '
        );

        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->upload();
            $event->setNbrGoing($event->getNbrGoing());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
        }
        $events = $query->getResult();

        return $this->render('events/index.html.twig', [
            'events' => $events,
        ]);

    }


    public function UpdateJoin(Events $event)
    {
        $part = $event->getNbrGoing();
        $part = $part + 1 ;
        $event->setNbrGoing($part);

        $this->getDoctrine()->getManager()->flush();


    }



}
