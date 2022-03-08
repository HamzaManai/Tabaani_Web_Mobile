<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\EventsType;
use App\Repository\EventsRepository;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
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
    public function index(EventsRepository $eventsRepository, Request $request, PaginatorInterface $paginator): Response
    {
        //tri date
        $data = $this->getDoctrine()->getRepository(Events::class)->findBy([],
        ['eventdate' => 'asc']
        );

        $events = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            3
    );

        return $this->render('events/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/new", name="events_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
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

            $file=$event->getImageevent();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory', $fileName));
            $event->setImageevent($fileName);
            //$event->upload();
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
     * @Route("/", name="event_search", methods={"POST"})
     */
    public function search(EventsRepository $eventsRepository, Request $request)
    {
        $data = $request->get('search');
        $event = $eventsRepository->findBy(['nsc'=>$data]);
        return $this->render('events/index.html.twig', [
                'event' => $event
        ]);
    }



}
