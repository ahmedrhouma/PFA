<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\CandidatsRepository;
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
        return $this->render('admins/baseAdmin.html.twig', [
            'error' => 0,
            'events' => $eventRepository->findAll(),
            'currentRoute' => $currentRoute,
            'text' => "",
            'title' => "",
            'footer' => "",
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
            $dateBegin = $form->get('date_start')->getData()->format('Y-m-d');

            if (strtotime(date("Y-m-d")) > strtotime($dateBegin)) {
                $event->setDateStart(\DateTime::createFromFormat('Y-m-d', date("Y-m-d")));
            }
            if (!empty($file)) {
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
            } else {
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
        return $this->render('admins/baseAdmin.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'currentRoute' => $currentRoute,
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event, Request $request , CandidatsRepository $candidatsRepository): Response
    {
        $currentRoute = $request->attributes->get('_route');

        return $this->render('admins/baseAdmin.html.twig', [
            'candidats' =>  $event->getCandidats() ,
            'electors' =>  $event->getElectors() ,
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


        return $this->render('admins/baseAdmin.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/{id}", name="event_update", methods={"UPDATE"})
     */
    public function delete(Request $request, Event $event, EventRepository $eventRepository): Response
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
//            return $this->redirectToRoute('event', [
//                'error' => 1
//            ]);
        }
        $title = "";
        if ($event->getStatus() == 0) {
            $title = "evenement en attente";
        } elseif ($event->getStatus() == 1) {
            $title = "evenement en marche";
        } elseif ($event->getStatus() == 2) {
            $title = "evenement en arrête";
        }


        $text = "";
        if ($event->getStatus() == 0) {
            $text = "l evenement " . $event->getTitle() . " est en attente";
        } elseif ($event->getStatus() == 1) {
            $text = "l evenement " . $event->getTitle() . " est en marche";
        } elseif ($event->getStatus() == 2) {
            $text = "l evenement " . $event->getTitle() . " est arrêté";
        }

        $footer = "";
        if ($event->getStatus() == 0) {
            $footer = "l'evenement est visible et en pause pour les electeurs";
        } elseif ($event->getStatus() == 1) {
            $footer = "l'evenement est visible et en marche pour les electeurs";
        } elseif ($event->getStatus() == 2) {
            $footer = "l'evenement non visible  pour les electeurs";
        }

        return $this->render('admins/baseAdmin.html.twig', [
            'error' => 1,
            'events' => $eventRepository->findAll(),
            'currentRoute' => 'event',
            'text' => $text,
            'title' => $title,
            'footer' => $footer,
        ]);
    }




}
