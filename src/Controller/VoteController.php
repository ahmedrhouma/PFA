<?php

namespace App\Controller;

use App\Entity\Candidats;
use App\Entity\Event;
use App\Entity\Elector;
use App\Entity\EncryptedVote;
use App\Form\EncryptedVoteType;
use App\Repository\ElectorRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ElectorType;
use App\Repository\EventRepository;
use App\Repository\EncryptedVoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\UserBundle\Form\Factory\FactoryInterface;

class VoteController extends Controller
{

    public function __construct(FactoryInterface $formFactory)
    {
        $this->formFactory     = $formFactory;
    }
    /**
     * @Route("/accueil", name="vote_accueil")
     */
    public function index(Request $request)
    {
        $currentRoute = $request->attributes->get('_route');
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null){
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }

        return $this->render('users/baseUsers.html.twig', [
            'currentRoute' => $currentRoute,
            'eventNumber' =>  $eventNumber,
            'userPhoto' => $userPhoto,
            'userId' => $userId,

        ]);
    }


//    /**
//     * @Route("/{id}/profileEdit", name="profileEdit", methods={"GET","POST"})
//     */
//    public function profileEdit(Request $request, Elector $elector): Response
//    {
//        $currentRoute = $request->attributes->get('_route');
//        $form = $this->createForm(ElectorType::class, $elector);
//        $form->handleRequest($request);
//        $formFactory = $this->formFactory;
//
//        $form1 = $formFactory->createForm();
//
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $file = $form->get('photo')->getData();
//
//            if (!empty($file)) {
//                $fileName = '' . md5(uniqid()) . '.' . $file->guessExtension();
//                // Move the file to the directory where images are stored
//                try {
//                    $file->move(
//                        $this->getParameter('upload_directory'),
//                        $fileName
//                    );
//                } catch (FileException $e) {
//                    // ... handle exception if something happens during file upload
//                }
//                // updates the 'image' property to store the PDF file name
//                // instead of its contents
//                $elector->setphoto($fileName);
//            } else {
//                $elector->setphoto('profile.jpg');
//            }
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('elector');
//        }
//
//        return $this->render('users/baseUsers.html.twig', [
//            'elector' => $elector,
//            'form' => $form->createView(),
//            'form1' => $form1->createView(),
//            'currentRoute' => $currentRoute,
//            'userPhoto' => $this->getUser()->getElector()->getPhoto()
//
//        ]);
//    }
    /**
     * @Route("/eventUser", name="eventUser")
     */
    public function showEvent(Request $request, EventRepository $eventRepository, ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' =>  $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,

        ]);
    }

    /**
     * @Route("/eventUser/coming", name="eventUser_coming")
     */
    public function showEventComing(Request $request, EventRepository $eventRepository, ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' => $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,
        ]);
    }


    /**
     * @Route("/eventUser/voter", name="eventUser_vo")
     */
    public function eventVo(Request $request, EventRepository $eventRepository, ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' =>  $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,
        ]);
    }

    /**
     * @Route("/eventUser/progress", name="eventUser_progress")
     */
    public function showEventProgress(Request $request, EventRepository $eventRepository, ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' =>  $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,
        ]);
    }

    /**
     * @Route("/eventUser/finished", name="eventUser_finished")
     */
    public function showEventFinished(Request $request, EventRepository $eventRepository, ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' =>  $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,
        ]);
    }

    /**
     * @Route("/eventResultat", name="eventResultat")
     */
    public function showEventTer(Request $request, EventRepository $eventRepository, ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' =>  $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,
        ]);
    }


    /**
     * @Route("/eventUser/{id}", name="eventUser_show" , methods={"GET"})
     */
    public function showEv(Event $event, Request $request, EventRepository $eventRepository)
    {

        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'candidats' =>  $event->getCandidats(),
            'events' => $eventRepository->findAll(),
            'event' => $event,
            'eventNumber' => $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,
        ]);
    }

    /**
     * @Route("/eventUser/candidat/{id}", name="eventUser_candidat_show" , methods={"GET"})
     */
    public function showCandidat(Candidats $candidat,  Request $request)
    {

        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'candidat' => $candidat,
            'eventNumber' => $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,

        ]);
    }


    /**
     * @Route("/eventUser/vote/{id}", name="eventUser_vote" , methods={"GET"})
     */
    public function voter(Event $event,  Request $request)
    {
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'candidats' => $event->getCandidats(),
            'eventNumber' => $eventNumber,
            'title' => $event->getTitle(),
            'event' => $event->getId(),
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,
        ]);
    }

    /**
     * @Route("/voter/{id}", name="voter" , methods={"GET","POST"})
     */
    public function vote($id, Request $request, EventRepository $EventRepository)
    {
        $idUser = $this->getUser()->getId();
        $choice = $_POST['choice'];
        $vote = new EncryptedVote();
        $VoteEntityManager = $this->getDoctrine()->getManager();
        $vote->setEvent($EventRepository->find($id));
        $vote->setVote(password_hash($choice, PASSWORD_DEFAULT));
        $vote->setDate(new \DateTime(date("Y-m-d H:i:s")));
        $VoteEntityManager->persist($vote);
        $VoteEntityManager->flush();
        return $this->redirectToRoute('eventUser');
    }

    /**
     * @Route("/eventUser/vote/{id}", name="eventUser_voter" , methods={"GET"})
     */
    public function eventVoter(Candidats $candidat,  Request $request)
    {
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'candidat' => $candidat,
            'eventNumber' => $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,

        ]);
    }



    /**
     * @Route("/eventUser/resultat/{id}", name="eventUser_result" , methods={"GET"})
     */
    public function result(Candidats $candidat,  Request $request)
    {
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'candidat' => $candidat,
            'eventNumber' => $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,

        ]);
    }


    /**
     * @Route("/note", name="eventUser_note" , methods={"GET"})
     */
    public function note(Request $request)
    {
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'eventNumber' => $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,

        ]);
    }

    /**
     * @Route("/aide", name="eventUser_aide" , methods={"GET"})
     */
    public function aide(Request $request)
    {
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'eventNumber' => $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,

        ]);
    }


    /**
     * @Route("/{id}/setting", name="eventUser_setting" , methods={"GET"})
     */
    public function setting (  Request $request, Elector $elector)
    {
        $currentRoute = $request->attributes->get('_route');
        $form = $this->createForm(ElectorType::class, $elector);
        $form->handleRequest($request);
        $formFactory = $this->formFactory;

        $form1 = $formFactory->createForm();


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
        $eventNumber = $this->getUser()->getElector()->getEvent();
        $eventNumber = count($eventNumber);

        return $this->render('users/baseUsers.html.twig', [
            'eventNumber' => $eventNumber,
            'elector' => $elector,
            'form' => $form->createView(),
            'form1' => $form1->createView(),
            'currentRoute' => $currentRoute,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),
            'userId' => $this->getUser()->getElector()->getId(),


        ]);
    }
}
