<?php

namespace App\Controller;

use App\Entity\Candidats;
use App\Entity\Event;
use App\Entity\Elector;
use App\Entity\EncryptedVote;
use App\Form\EncryptedVoteType;
use App\Repository\ElectorRepository;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ElectorType;
use App\Repository\EventRepository;
use App\Repository\EncryptedVoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class VoteController extends Controller
{

    public function __construct(FactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/accueil", name="vote_accueil")
     */
    public function index(Request $request)
    {
        $currentRoute = $request->attributes->get('_route');
        $eventNumber = 0;
        $userPhoto = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }

        return $this->render('users/baseUsers.html.twig', [
            'currentRoute' => $currentRoute,
            'eventNumber' => $eventNumber,
            'userPhoto' => $userPhoto,
            'userId' => $userId,

        ]);
    }

    /**
     * @Route("/eventUser", name="eventUser")
     */
    public function showEvent(Request $request, EventRepository $eventRepository, EncryptedVoteRepository $encryptedVoteRepository)
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
        $events = $user->getElector()->getEvent();
        foreach ($events as $event) {
            $already = $encryptedVoteRepository->findBy(['event' => $eventRepository->find($event->getId()), 'elector' => $this->getUser()->getElector()->getId()]);
            if ($already) {
                $event->setVoted(1);
            } else $event->setVoted(0);
        }
        return $this->render('users/baseUsers.html.twig', [

            'events' => $events,
            'eventNumber' => $eventNumber,
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
    public function eventVo(Request $request, EventRepository $eventRepository, ElectorRepository $electorRepository, EncryptedVoteRepository $encryptedVoteRepository)
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

        $events = $user->getElector()->getEvent();
        foreach ($events as $event) {
            $already = $encryptedVoteRepository->findBy(['event' => $eventRepository->find($event->getId()), 'elector' => $this->getUser()->getElector()->getId()]);
            if ($already) {
                $event->setVoted(1);
            } else $event->setVoted(0);
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
            'eventNumber' => $eventNumber,
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
            'eventNumber' => $eventNumber,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,
        ]);
    }

    /**
     * @Route("/eventResultat", name="eventResultat")
     */
    public function showEventTer(UserPasswordEncoderInterface $encoder, Request $request, EventRepository $eventRepository, ElectorRepository $electorRepository)
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
            'candidats' => $event->getCandidats(),
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
    public function showCandidat(Candidats $candidat, Request $request)
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
    public function voter(Event $event, Request $request, EncryptedVoteRepository $encryptedVoteRepository)
    {
        $eventNumber = 0;
        $userPhoto = null;
        $candidats = null;
        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }

        $already = $encryptedVoteRepository->findBy(['event' => $event->getId(), 'elector' => $this->getUser()->getElector()->getId()]);
        if ($already) {
            $event->setVoted(1);
        } else $event->setVoted(0);
        $vote = $encryptedVoteRepository->findOneBy(['event' => $event, 'elector' => $userId]);

        foreach ($event->getCandidats() as $candidat) {

            if ($vote != Null) {
                if (password_verify($candidat->getId(), $vote->getVote())) {
                    $candidats = $candidat;
                }
            }

        }

        $currentRoute = $request->attributes->get('_route');


        return $this->render('users/baseUsers.html.twig', [
            'candidats' => $event->getCandidats(),
            'eventNumber' => $eventNumber,
            'title' => $event->getTitle(),
            'eventId' => $event->getId(),
            'event' => $event,
            'currentRoute' => $currentRoute,
            'userPhoto' => $userPhoto,
            'userId' => $userId,
            'eventVoted' => $event->getVoted(),
            'candidat' => $candidats,
            'candidatNumber' => count($event->getCandidats()),
        ]);
    }

    /**
     * @Route("/voter/{id}", name="voter" , methods={"GET","POST"})
     */
    public function vote($id, Request $request, EventRepository $EventRepository, EncryptedVoteRepository $encryptedVoteRepository)
    {
        $idUser = $this->getUser()->getId();
        $choice = $_POST['choice'];
        $already = $encryptedVoteRepository->findBy(['event' => $EventRepository->find($id), 'elector' => $this->getUser()->getElector()->getId()]);
        if (!$already) {

            $vote = new EncryptedVote();
            $VoteEntityManager = $this->getDoctrine()->getManager();
            $vote->setEvent($EventRepository->find($id));
            $vote->setVote(password_hash($choice, PASSWORD_DEFAULT));
            $vote->setDate(new \DateTime(date("Y-m-d H:i:s")));
            $vote->setElector($this->getUser()->getElector()->getId());
            $VoteEntityManager->persist($vote);
            $VoteEntityManager->flush();
        }
        return $this->redirectToRoute('eventUser');
    }

    /**
     * @Route("/eventUser/vote/{id}", name="eventUser_voter" , methods={"GET"})
     */
    public function eventVoter(Candidats $candidat, Request $request)
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
     * @Route("/eventUser/resultat/{id}", name="eventUser_result" , methods={"GET"})
     */
    public function result($id, Event $event, Request $request, EventRepository $EventRepository, EncryptedVoteRepository $EncryptedVoteRepository)
    {
        $eventNumber = 0;
        $userPhoto = null;

        if ($this->getUser()->getElector() != null) {
            $eventNumber = $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
            $userPhoto = $this->getUser()->getElector()->getPhoto();
            $userId = $this->getUser()->getElector()->getId();
        }
        $event = $EventRepository->find($id);
        $votes = $EncryptedVoteRepository->findBy(['event' => $event]);
        $candidats = $event->getCandidats();
        foreach ($candidats as $candidat) {
            foreach ($votes as $vote) {
                if (password_verify($candidat->getId(), $vote->getVote())) {
                    $candidat->addVotes();
                }
            }
            $candidat->setPercentage(($candidat->getVotes() / count($votes)) * 100);
        }
        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'event' => $EventRepository->find($id),
            'candidats' => $candidats,
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
    public function setting(Request $request, Elector $elector)
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
