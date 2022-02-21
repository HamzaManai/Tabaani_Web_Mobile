<?php

namespace App\Controller;

use App\Entity\EventProgram;
use App\Form\EventProgramType;
use App\Repository\EventProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event/program")
 */
class EventProgramController extends AbstractController
{
    /**
     * @Route("/", name="event_program_index", methods={"GET"})
     */
    public function index(EventProgramRepository $eventProgramRepository): Response
    {
        return $this->render('event_program/index.html.twig', [
            'event_programs' => $eventProgramRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="event_program_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventProgram = new EventProgram();
        $form = $this->createForm(EventProgramType::class, $eventProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventProgram);
            $entityManager->flush();

            return $this->redirectToRoute('event_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event_program/new.html.twig', [
            'event_program' => $eventProgram,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_program_show", methods={"GET"})
     */
    public function show(EventProgram $eventProgram): Response
    {
        return $this->render('event_program/show.html.twig', [
            'event_program' => $eventProgram,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_program_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EventProgram $eventProgram, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventProgramType::class, $eventProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('event_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event_program/edit.html.twig', [
            'event_program' => $eventProgram,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_program_delete", methods={"POST"})
     */
    public function delete(Request $request, EventProgram $eventProgram, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventProgram->getId(), $request->request->get('_token'))) {
            $entityManager->remove($eventProgram);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_program_index', [], Response::HTTP_SEE_OTHER);
    }
}
