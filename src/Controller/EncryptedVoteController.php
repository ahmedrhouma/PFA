<?php

namespace App\Controller;

use App\Entity\EncryptedVote;
use App\Form\EncryptedVoteType;
use App\Repository\EncryptedVoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/encrypted/vote")
 */
class EncryptedVoteController extends AbstractController
{
    /**
     * @Route("/", name="encrypted_vote_index", methods={"GET"})
     */
    public function index(EncryptedVoteRepository $encryptedVoteRepository): Response
    {
        return $this->render('encrypted_vote/index.html.twig', [
            'encrypted_votes' => $encryptedVoteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="encrypted_vote_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $encryptedVote = new EncryptedVote();
        $form = $this->createForm(EncryptedVoteType::class, $encryptedVote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($encryptedVote);
            $entityManager->flush();

            return $this->redirectToRoute('encrypted_vote_index');
        }

        return $this->render('encrypted_vote/new.html.twig', [
            'encrypted_vote' => $encryptedVote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="encrypted_vote_show", methods={"GET"})
     */
    public function show(EncryptedVote $encryptedVote): Response
    {
        return $this->render('encrypted_vote/show.html.twig', [
            'encrypted_vote' => $encryptedVote,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="encrypted_vote_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EncryptedVote $encryptedVote): Response
    {
        $form = $this->createForm(EncryptedVoteType::class, $encryptedVote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('encrypted_vote_index');
        }

        return $this->render('encrypted_vote/edit.html.twig', [
            'encrypted_vote' => $encryptedVote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="encrypted_vote_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EncryptedVote $encryptedVote): Response
    {
        if ($this->isCsrfTokenValid('delete'.$encryptedVote->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($encryptedVote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('encrypted_vote_index');
    }
}
