<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Form\ListeType;
use App\Repository\ListeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/liste")
 */
class ListeController extends AbstractController
{
    /**
     * @Route("/", name="liste_index", methods={"GET"})
     */
    public function index(ListeRepository $listeRepository): Response
    {
        return $this->render('liste/index.html.twig', [
            'listes' => $listeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="liste_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($liste);
            $entityManager->flush();

            return $this->redirectToRoute('liste_index');
        }

        return $this->render('liste/new.html.twig', [
            'liste' => $liste,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="liste_show", methods={"GET"})
     */
    public function show(Liste $liste): Response
    {
        return $this->render('liste/show.html.twig', [
            'liste' => $liste,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="liste_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Liste $liste): Response
    {
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('liste_index');
        }

        return $this->render('liste/edit.html.twig', [
            'liste' => $liste,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="liste_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Liste $liste): Response
    {
        if ($this->isCsrfTokenValid('delete'.$liste->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($liste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('liste_index');
    }
}
