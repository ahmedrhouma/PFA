<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Form\ListeType;
use App\Repository\CandidatsRepository;
use App\Repository\ListeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/listes")
 */
class ListeController extends AbstractController
{
    /**
     * @Route("/", name="liste", methods={"GET"})
     */
    public function index(ListeRepository $listeRepository , Request $request): Response
    {
        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/dashboard/dashboard.html.twig', [
            'listes' => $listeRepository->findAll(),
            'currentRoute' => $currentRoute
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

        $currentRoute = $request->attributes->get('_route');

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('photo')->getData();
            $fileName =''.md5(uniqid()).'.'.$file->guessExtension();
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

            $liste->setphoto($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($liste);
            $entityManager->flush();

            return $this->redirectToRoute('liste');
        }

        return $this->render('admins/dashboard/dashboard.html.twig', [
            'liste' => $liste,
            'form' => $form->createView(),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/{id}", name="liste_show", methods={"GET"})
     */
    public function show(Liste $liste  ,  Request $request ,  CandidatsRepository $candidatsRepository ): Response
    {
        $id = $request->get('id');
        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/dashboard/dashboard.html.twig', [
            'liste' => $liste,
            'candidats' => $candidatsRepository->findBy(array('liste'=>$id)),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/{id}/edit", name="liste_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Liste $liste): Response
    {
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);
        $currentRoute = $request->attributes->get('_route');
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('liste');
        }

        return $this->render('admins/dashboard/dashboard.html.twig', [
            'liste' => $liste,
            'form' => $form->createView(),
            'currentRoute' => $currentRoute
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

        return $this->redirectToRoute('liste');
    }
}
