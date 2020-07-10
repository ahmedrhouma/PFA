<?php

namespace App\Controller;

use App\Entity\Candidats;
use App\Entity\Elector;
use App\Entity\Event;
use App\Form\ElectorType;
use App\Repository\ElectorRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/elector")
 */
class ElectorController extends Controller
{
    /**
     * @Route("/", name="elector", methods={"GET"})
     */
    public function index(EventRepository $eventRepository, ElectorRepository $electorRepository, Request $request): Response
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/baseAdmin.html.twig', [
            'electors' => $electorRepository->findAll(),
            'events' => $eventRepository->findAll(),
            'currentRoute' => $currentRoute
        ]);
    }

    /**
     * @Route("/filterByEvent/{id}", name="filterByEvent", methods={"GET","POST"})
     */
    public function filterByEvent($id, EventRepository $eventRepository, ElectorRepository $electorRepository, Request $request)
    {
        $event = intval($id);
        if ($event != 0) {
            $event = $eventRepository->findOneBy(['id' => $event]);
            $electors = $event->getElectors();
        } else {
            $electors = $electorRepository->findAll();
        }
        $result = array();
        foreach ($electors as $elector) {
            $url = $this->generateUrl(
                'elector_show',
                ['id' => $elector->getId()]
            );
            $url2 = $this->generateUrl(
                'elector_edit',
                ['id' => $elector->getId()]
            );
            $result[] = array('<img style="width: 50px" src="/uploads/profile.jpg" alt="">', $elector->getCin(), $elector->getFirstName() . ' ' . $elector->getLastName(), $elector->getEmail(), $elector->getPhone(), $elector->getGender() == 0 ? 'Homme' : 'Femme', "<a class='label danger' href='" . $url . "'>Montrer</a><a class='label success' href='" . $url2 . "'>Modifier</a>");
        }
        return new JsonResponse($result);
    }

    /**
     * @Route("/new", name="elector_new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer): Response
    {
        $elector = new Elector();
        $form = $this->createForm(ElectorType::class, $elector);
        $form->handleRequest($request);
        $currentRoute = $request->attributes->get('_route');
        $userManager = $this->get('fos_user.user_manager');
        $entityManager = $this->getDoctrine()->getManager();
        $row = 0;
        $form1 = $this->createFormBuilder()
            ->add('input', FileType::class, ['required' => true, 'attr' => [
                'accept' => '.csv',
                'name' => "file1",
                'id' => "input-file-now",
                'name' => "file1",
                'class' => "dropify uploadlogo"
            ]])
            ->add('event', EntityType::class, ['required' => true, 'class' => Event::class, 'attr' => [
                'class' => 'form-control'
            ]])
            ->getForm();
        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {
            if ($form1->get('input')->getData()) {
                $csvFile = fopen($form1->get('input')->getData(), 'r');
                $event = $form1->get('event')->getData();
                while (($line = fgetcsv($csvFile, 1000, ";")) !== FALSE) {
                    if ($row != 0) {
                        $cin = (isset($line[0]) && $line[0] != '') ? $line[0] : NULL;
                        $firstname = (isset($line[1]) && $line[1] != '') ? $line[1] : NULL;
                        $lastname = (isset($line[2]) && $line[2] != '') ? $line[2] : NULL;
                        $phone = (isset($line[3]) && $line[3] != '') ? $line[3] : NULL;
                        $birth = (isset($line[4]) && $line[4] != '') ? $line[4] : NULL;
                        $gender = (isset($line[5]) && $line[5] != '') ? $line[5] : NULL;
                        $email = (isset($line[6]) && $line[6] != '') ? $line[6] : NULL;
                        $email_exist = $userManager->findUserByEmail($email);
                        if ($email_exist) {
                            return $this->render('admins/baseAdmin.html.twig', [
                                'error' => 1,
                                'form' => $form->createView(),
                                'form1' => $form1->createView(),
                                'currentRoute' => $currentRoute
                            ]);
                        }
                        $cin_Exist = $this->getDoctrine()
                            ->getRepository(Elector::class)
                            ->findOneBy(['cin' => $cin]);
                        if ($cin_Exist) {
                            return $this->render('admins/baseAdmin.html.twig', [
                                'error' => 1,
                                'form' => $form->createView(),
                                'form1' => $form1->createView(),
                                'currentRoute' => $currentRoute
                            ]);
                        }
                        $password = $firstname . uniqid();
                        $user = $userManager->createUser();
                        $user->setUsername($firstname . $lastname);
                        $user->setEmail($email);
                        $user->setEmailCanonical($email);
                        $user->setEnabled(1);
                        $user->setRoles(['ROLE_ELECTOR']);
                        $user->setPlainPassword($password);
                        $userManager->updateUser($user);
                        $elector = new Elector();
                        $elector->setPhone(intval($phone));
                        $elector->setFirstName($firstname);
                        $elector->setLastName($lastname);
                        $elector->setCin(intval($cin));
                        $elector->setGender($gender);
                        $elector->setEmail($email);
                        $elector->addEvent($event);
                        $elector->setBirth(new \DateTime($birth));
                        $elector->setPhoto('profile.jpg');
                        $emailSend = (new Email())
                            ->from('EvotePro@gmail.com')
                            ->to($email)
                            ->subject('Bienvenue a E-Vote!')
                            ->html('<div style="text-align:center"><div style="margin-bottom:30px">Bonjour MR/MRS <strong>' . $lastname . ' ' . $firstname . '</strong></div><div style="margin-bottom:10px">login : ' . $email . '</div><div style="margin-bottom:10px"> mot de passe : ' . $password . ' </div><div><button><a href="#">accedés a votre espace</a></button></div></div>');

                        $mailer->send($emailSend);
                        $entityManager->persist($elector);
                        $entityManager->flush();
                    }
                    $row++;
                }
                return $this->redirectToRoute('elector');
            }

            foreach ($elector->getEvent() as $event) {
                $elector->addEvent($event);
            }
            $file = $form->get('photo')->getData();
            $email_exist = $userManager->findUserByEmail($form->get('email')->getData());
            if ($email_exist) {
                return $this->render('admins/baseAdmin.html.twig', [
                    'error' => 1,
                    'form' => $form->createView(),
                    'form1' => $form1->createView(),
                    'currentRoute' => $currentRoute
                ]);
            }


            $cin_Exist = $this->getDoctrine()
                ->getRepository(Elector::class)
                ->findOneBy(['cin' => $form->get('cin')->getData()]);
            if ($cin_Exist) {
                return $this->render('admins/baseAdmin.html.twig', [
                    'error' => 1,
                    'form' => $form->createView(),
                    'form1' => $form1->createView(),
                    'currentRoute' => $currentRoute
                ]);
            }
            $candidat = new Candidats();
            if ($request->get("candidat") != null) {

                $candidat->setCin($form->get('cin')->getData());
                $candidat->setFirstName($form->get('first_name')->getData());
                $candidat->setLastName($form->get('last_name')->getData());
                $candidat->setEmail($form->get('email')->getData());
                $candidat->setGender($form->get('gender')->getData());
                $candidat->setDateOfBirth($form->get('date_of_birth')->getData());
                $candidat->setPhone($form->get('phone')->getData());
                $candidat->setphoto('profile.jpg');
                $candidat->setDescription($form->get('first_name')->getData());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($candidat);
                $entityManager->flush();
            }


            $password = $form->get('first_name')->getData() . uniqid();
            $user = $userManager->createUser();
            $user->setUsername($form->get('first_name')->getData() . $form->get('last_name')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setEmailCanonical($form->get('email')->getData());
            $user->setEnabled(1);
            $user->setRoles(['ROLE_ELECTOR']);
            $user->setPlainPassword($password);
            $userManager->updateUser($user);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $elector->getFirstName() . uniqid();
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

                if (($form->get('photo')->getData() != null) && ($request->get("candidat") != null)) {

                    $candidat->setphoto($fileName);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($candidat);
                    $entityManager->flush();
                }
            } else {
                $elector->setphoto('profile.jpg');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($elector);
            $entityManager->flush();
            $email = (new Email())
                ->from('EvotePro@gmail.com')
                ->to($form->get('email')->getData())
                ->subject('Bienvenue a E-Vote!')
                ->html('<div style="text-align:center"><div style="margin-bottom:30px">Bonjour MR/MRS <strong>' . $form->get('last_name')->getData() . ' ' . $form->get('first_name')->getData() . '</strong></div><div style="margin-bottom:10px">login : ' . $form->get('email')->getData() . '</div><div style="margin-bottom:10px"> mot de passe : ' . $password . ' </div><div><button><a href="#">accedés a votre espace</a></button></div></div>');

            $mailer->send($email);

            return $this->redirectToRoute('elector');
        }


        return $this->render('admins/baseAdmin.html.twig', [
            'elector' => $elector,
            'form' => $form->createView(),
            'form1' => $form1->createView(),
            'currentRoute' => $currentRoute,
            'error' => 0
        ]);
    }

    /**
     * @Route("/{id}", name="elector_show", methods={"GET"})
     */
    public function show(Elector $elector, Request $request): Response
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/baseAdmin.html.twig', [
            'elector' => $elector,
            'events' => $elector->getEvent(),
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

        return $this->render('admins/baseAdmin.html.twig', [
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
