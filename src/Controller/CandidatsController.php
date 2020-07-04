<?php

namespace App\Controller;

use App\Entity\Candidats;
use App\Form\CandidatsType;
use App\Repository\CandidatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * @Route("/candidats")
 */
class CandidatsController extends AbstractController
{
    /**
     * @Route("/", name="candidats", methods={"GET"})
     */
    public function index(CandidatsRepository $candidatsRepository , Request $request): Response
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/dashboard/dashboard.html.twig', [
            'candidats' => $candidatsRepository->findAll(),
            'currentRoute' => $currentRoute
        ]);


    }

    /**
     * @Route("/new", name="candidats_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($request->get('upload') !== null) {
            if (is_uploaded_file($_FILES['file1']['tmp_name'])) {
                $csvFile = fopen($_FILES['file1']['tmp_name'], 'r');
                $row = 0;
                while (($line = fgetcsv($csvFile, 1000, ";")) !== FALSE) {
                    if ($row > 0) {
                        $cin = (isset($line[0]) && $line[0] != '') ? $line[0] : NULL;
                        $firstname = (isset($line[1]) && $line[1] != '') ? $line[1] : NULL;
                        $lastname = (isset($line[2]) && $line[2] != '') ? $line[2] : NULL;
                        $phone = (isset($line[3]) && $line[3] != '') ? $line[3] : NULL;
                        $birth = (isset($line[4]) && $line[4] != '') ? $line[4] : NULL;
                        $gender = (isset($line[5]) && $line[5] != '') ? $line[5] : NULL;
                        $email = (isset($line[6]) && $line[6] != '') ? $line[6] : NULL;
                        $candidat = new Candidats();
                        $candidat->setPhone(intval($phone));
                        $candidat->setFirstName($firstname);
                        $candidat->setLastName($lastname);
                        $candidat->setCin(intval($cin));
                        $candidat->setGender($gender);
                        $candidat->setEmail($email);
                        $candidat->setDateOfBirth(new \DateTime($birth));
                        $candidat->setPhoto('profile.jpg');
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($candidat);
                        $entityManager->flush();
                    }
                    $row++;
                }
            }
        }
        $candidat = new Candidats();
        $form = $this->createForm(CandidatsType::class, $candidat);
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

            $candidat->setphoto($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidat);
            $entityManager->flush();

            return $this->redirectToRoute('candidats');
        }

        return $this->render('admins/dashboard/dashboard.html.twig', [
            'candidat' => $candidat,
            'form' => $form->createView(),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/{id}", name="candidats_show", methods={"GET"})
     */
    public function show(Candidats $candidat ,  Request $request): Response
    {
        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/dashboard/dashboard.html.twig', [
            'candidat' => $candidat,
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/{id}/edit", name="candidats_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Candidats $candidat): Response
    {
        $form = $this->createForm(CandidatsType::class, $candidat);
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

            $candidat->setphoto($fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidats');
        }

        return $this->render('admins/dashboard/dashboard.html.twig', [
            'candidat' => $candidat,
            'form' => $form->createView(),
            'currentRoute' => $currentRoute
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

        return $this->redirectToRoute('candidats');
    }
}
