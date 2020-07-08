<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event", methods={"GET"})
     */
    public function index(EventRepository $eventRepository, Request $request): Response
    {
        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/dashboard/dashboard.html.twig', [
            'events' => $eventRepository->findAll(),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('photo')->getData();
            $fileName = '' . md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where images are stored
            try {
                $file->move(
                    $this->getParameter('upload_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            // updates the 'image' property to store the PDF file name
            // instead of its contents
            if (!empty($file)) {
                $event->setphoto($fileName);
            }
            else{
                $event->setphoto('event.jpg');
            }
            $event->setStatus(0);
            if ($form->get('duration')->getData() > 0) {
                $event->setDateEnd(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime("+" . $form->get('duration')->getData() . "day", strtotime($event->getDateStart()->format('Y-m-d'))))));

            } else {
                $event->setDateEnd(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime(($event->getDateStart()->format('Y-m-d'))))));
                $event->setDuration(1);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event');
        }
        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/dashboard/dashboard.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'currentRoute' => $currentRoute,
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event, Request $request): Response
    {
        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/dashboard/dashboard.html.twig', [
            'event' => $event,
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        $currentRoute = $request->attributes->get('_route');
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('photo')->getData();
            $fileName = '' . md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where images are stored
            try {
                $file->move(
                    $this->getParameter('upload_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            // updates the 'image' property to store the PDF file name
            // instead of its contents

            $event->setphoto($fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event');
        }


        return $this->render('admins/dashboard/dashboard.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/{id}", name="event_update", methods={"UPDATE"})
     */
    public function delete(Request $request, Event $event): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        if ($this->isCsrfTokenValid('pause' . $event->getId(), $request->request->get('_token'))) {
            $pause = $this->getDoctrine()
                ->getRepository(Event::class)
                ->find($event);
            $pause->setStatus(0);
            $entityManager->flush();
        }

        if ($this->isCsrfTokenValid('start' . $event->getId(), $request->request->get('_token'))) {
            $start = $this->getDoctrine()
                ->getRepository(Event::class)
                ->find($event);
            $start->setStatus(1);
            if (date("Y-m-d") < strtotime($start->getDateStart()->format('Y-m-d'))) {
                $start->setDateStart(\DateTime::createFromFormat('Y-m-d', date("Y-m-d")));
                $start->setDateEnd(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime("+" . $start->getDuration() . "day", strtotime($start->getDateStart()->format('Y-m-d'))))));
            }

            $entityManager->flush();
        }

        if ($this->isCsrfTokenValid('stop' . $event->getId(), $request->request->get('_token'))) {
            $stop = $this->getDoctrine()
                ->getRepository(Event::class)
                ->find($event);
            $stop->setStatus(2);

            $stop->setDateEnd(\DateTime::createFromFormat('Y-m-d', date("Y-m-d")));

            $entityManager->flush();
        }

        return $this->redirectToRoute('event');
    }
}
