<?php

namespace App\Controller;

use App\Entity\Candidats;
use App\Form\CandidatsType;
use App\Repository\CandidatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/candidats")
 */
class CandidatsController extends AbstractController
{
    /**
     * @Route("/", name="candidats_index", methods={"GET"})
     */
    public function index(CandidatsRepository $candidatsRepository): Response
    {
        return $this->render('candidats/index.html.twig', [
            'candidats' => $candidatsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="candidats_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $candidat = new Candidats();
        $form = $this->createForm(CandidatsType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidat);
            $entityManager->flush();

            return $this->redirectToRoute('candidats_index');
        }

        return $this->render('candidats/new.html.twig', [
            'candidat' => $candidat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="candidats_show", methods={"GET"})
     */
    public function show(Candidats $candidat): Response
    {
        return $this->render('candidats/show.html.twig', [
            'candidat' => $candidat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="candidats_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Candidats $candidat): Response
    {
        $form = $this->createForm(CandidatsType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidats_index');
        }

        return $this->render('candidats/edit.html.twig', [
            'candidat' => $candidat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="candidats_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Candidats $candidat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($candidat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('candidats_index');
    }
}
