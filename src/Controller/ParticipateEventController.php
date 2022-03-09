<?php

namespace App\Controller;

use App\Entity\Events;
use App\Entity\ParticipateEvent;
use App\Entity\User;
use App\Form\ParticipateEventType;
use App\Repository\EventsRepository;
use App\Repository\ParticipateEventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participate/event")
 */
class ParticipateEventController extends AbstractController
{
    /**
     * @Route("/", name="participate_event_index", methods={"GET"})
     */
    public function index(ParticipateEventRepository $participateEventRepository): Response
    {
        return $this->render('participate_event/index.html.twig', [
            'participate_events' => $participateEventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="participate_event_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $participateEvent = new ParticipateEvent();
        $form = $this->createForm(ParticipateEventType::class, $participateEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participateEvent);
            $entityManager->flush();

            return $this->redirectToRoute('participate_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participate_event/new.html.twig', [
            'participate_event' => $participateEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participate_event_show", methods={"GET"})
     */
    public function show(ParticipateEvent $participateEvent): Response
    {
        return $this->render('participate_event/show.html.twig', [
            'participate_event' => $participateEvent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="participate_event_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ParticipateEvent $participateEvent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParticipateEventType::class, $participateEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('participate_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participate_event/edit.html.twig', [
            'participate_event' => $participateEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participate_event_delete", methods={"POST"})
     */
    public function delete(Request $request, ParticipateEvent $participateEvent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participateEvent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($participateEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('participate_event_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/newTrying/new", name="participate_event_newTrying", methods={"POST"})
     */
    public function newTrying(Request $request,EventsController $eventsController,ParticipateEventRepository $participateEventRepository ,EventsRepository $eventsRepository, UserRepository $userRepository)
    {
        $event = new Events();
        $data=$request->request->get('myEvent');
//var_dump($data);

        $event = $eventsRepository->findOneBy([ 'id' => 15]);
        $user= new User();
        $user = $userRepository->findOneBy(['prenomUser' => 'Cyrine']);
        /*var_dump($event);
        die();*/
        //$event = $this->getDoctrine()->getRepository(Events::class)->findOneBy(['id' => $data]);
        $participant = new ParticipateEvent();
        $participant->setEvent($event);
        $participant->setUser($user);

            $eventsController->UpdateJoin($event);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();

        return $this->render('events/index.html.twig', [
            'events' => $eventsRepository->findAll(),
        ]);
    }

}
