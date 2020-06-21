<?php

namespace App\Controller;

use App\Entity\Elector;
use App\Form\ElectorType;
use App\Repository\ElectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/elector")
 */
class ElectorController extends AbstractController
{
    /**
     * @Route("/", name="elector_index", methods={"GET"})
     */
    public function index(ElectorRepository $electorRepository): Response
    {
        return $this->render('elector/index.html.twig', [
            'electors' => $electorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="elector_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $elector = new Elector();
        $form = $this->createForm(ElectorType::class, $elector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($elector);
            $entityManager->flush();

            return $this->redirectToRoute('elector_index');
        }

        return $this->render('elector/new.html.twig', [
            'elector' => $elector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="elector_show", methods={"GET"})
     */
    public function show(Elector $elector): Response
    {
        return $this->render('elector/show.html.twig', [
            'elector' => $elector,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="elector_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Elector $elector): Response
    {
        $form = $this->createForm(ElectorType::class, $elector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('elector_index');
        }

        return $this->render('elector/edit.html.twig', [
            'elector' => $elector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="elector_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Elector $elector): Response
    {
        if ($this->isCsrfTokenValid('delete'.$elector->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($elector);
            $entityManager->flush();
        }

        return $this->redirectToRoute('elector_index');
    }
}
