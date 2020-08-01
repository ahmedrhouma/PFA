<?php

namespace App\Controller;

use App\Entity\EventResult;
use App\Form\EventResultType;
use App\Repository\EventResultRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event/result")
 */
class EventResultController extends AbstractController
{
    /**
     * @Route("/", name="event_result_index", methods={"GET"})
     */
    public function index(EventResultRepository $eventResultRepository,  Request $request): Response
    {
        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/event_result/baseUsers.html.twig', [
            'event_results' => $eventResultRepository->findAll(),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/new", name="event_result_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $eventResult = new EventResult();
        $form = $this->createForm(EventResultType::class, $eventResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventResult);
            $entityManager->flush();

            return $this->redirectToRoute('event_result_index');
        }

        return $this->render('event_result/new.html.twig', [
            'event_result' => $eventResult,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_result_show", methods={"GET"})
     */
    public function show(EventResult $eventResult): Response
    {
        return $this->render('event_result/show.html.twig', [
            'event_result' => $eventResult,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_result_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventResult $eventResult): Response
    {
        $form = $this->createForm(EventResultType::class, $eventResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_result_index');
        }

        return $this->render('event_result/edit.html.twig', [
            'event_result' => $eventResult,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_result_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EventResult $eventResult): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventResult->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventResult);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_result_index');
    }
}
