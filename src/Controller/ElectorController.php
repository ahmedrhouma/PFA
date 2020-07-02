<?php

namespace App\Controller;

use App\Entity\Elector;
use App\Form\ElectorType;
use App\Repository\ElectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * @Route("/elector")
 */
class ElectorController extends AbstractController
{
    /**
     * @Route("/", name="elector", methods={"GET"})
     */
    public function index(ElectorRepository $electorRepository, Request $request): Response
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/dashboard/dashboard.html.twig', [
            'electors' => $electorRepository->findAll(),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/new", name="elector_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($request->get('upload')!== null) {
            if (is_uploaded_file($_FILES['file1']['tmp_name'])) {
                $csvFile = fopen($_FILES['file1']['tmp_name'], 'r');
                while (($line = fgetcsv($csvFile, 1000, ";")) !== FALSE) {
                    $phone = (isset($line[0]) && $line[0] != '') ? $line[0] : NULL;
                    $firstname = (isset($line[1]) && $line[1] != '') ? $line[1] : NULL;
                    $lastname = (isset($line[2]) && $line[2] != '') ? $line[2] : NULL;
                    $cin = (isset($line[3]) && $line[3] != '') ? $line[3] : NULL;
                    $birth = (isset($line[4]) && $line[4] != '') ? $line[4] : NULL;
                    $gender = (isset($line[5]) && $line[5] != '') ? $line[5] : NULL;
                    $email = (isset($line[6]) && $line[6] != '') ? $line[6] : NULL;
                    $elector = new Elector();
                    $elector->setPhone(intval($phone));
                    $elector->setFirstName($firstname);
                    $elector->setLastName($lastname);
                    $elector->setCin(intval($cin));
                    $elector->setGender($gender);
                    $elector->setEmail($email);
                    $elector->setBirth(new \DateTime(strtotime($birth)));
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($elector);
                    $entityManager->flush();
                }
            }
        }
        $elector = new Elector();
        $form = $this->createForm(ElectorType::class, $elector);
        $form->handleRequest($request);
        $currentRoute = $request->attributes->get('_route');
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('photo')->getData();

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
                $elector->setphoto($fileName);
            } else {
                $elector->setphoto('profile.jpg');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($elector);
            $entityManager->flush();

            return $this->redirectToRoute('elector');
        }

        return $this->render('admins/dashboard/dashboard.html.twig', [
            'elector' => $elector,
            'form' => $form->createView(),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/{id}", name="elector_show", methods={"GET"})
     */
    public function show(Elector $elector, Request $request): Response
    {
        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/dashboard/dashboard.html.twig', [
            'elector' => $elector,
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/{id}/edit", name="elector_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Elector $elector): Response
    {
        $currentRoute = $request->attributes->get('_route');
        $form = $this->createForm(ElectorType::class, $elector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('photo')->getData();

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
                $elector->setphoto($fileName);
            } else {
                $elector->setphoto('profile.jpg');
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('elector');
        }

        return $this->render('admins/dashboard/dashboard.html.twig', [
            'elector' => $elector,
            'form' => $form->createView(),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/{id}", name="elector_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Elector $elector): Response
    {
        if ($this->isCsrfTokenValid('delete' . $elector->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($elector);
            $entityManager->flush();
        }

        return $this->redirectToRoute('elector');
    }
}
