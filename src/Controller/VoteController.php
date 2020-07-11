<?php

namespace App\Controller;

use App\Entity\Candidats;
use App\Entity\Event;
use App\Repository\ElectorRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class VoteController extends AbstractController
{


    /**
     * @Route("/accueil", name="vote_accueil")
     */
    public function index( Request $request)
    {
        $currentRoute = $request->attributes->get('_route');
        $eventNumber = 0;
        if ($this->getUser()->getElector() != null){
            $eventNumber= $this->getUser()->getElector()->getEvent();
            $eventNumber = count($eventNumber);
        }
        
        return $this->render('users/baseUsers.html.twig', [
            'currentRoute' => $currentRoute,
            'eventNumber' =>  $eventNumber,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),

        ]);

    }

    /**
     * @Route("/eventUser", name="eventUser")
     */
    public function showEvent( Request $request , EventRepository $eventRepository,ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' =>  count($this->getUser()->getElector()->getEvent()),
            'currentRoute' => $currentRoute,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),

        ]);

    }

    /**
     * @Route("/eventUser/coming", name="eventUser_coming")
     */
    public function showEventComing( Request $request , EventRepository $eventRepository,ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' =>  count($this->getUser()->getElector()->getEvent()),
            'currentRoute' => $currentRoute,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),

        ]);

    }

    /**
     * @Route("/eventUser/progress", name="eventUser_progress")
     */
    public function showEventProgress( Request $request , EventRepository $eventRepository,ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        $eventNumber = 0 ;
        if ($this->getUser()->getElector()->getEvent() != null){

            $eventNumber= $this->getUser()->getElector()->getEvent();
        }
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' =>  count($eventNumber),
            'currentRoute' => $currentRoute,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),

        ]);

    }

    /**
     * @Route("/eventUser/finished", name="eventUser_finished")
     */
    public function showEventFinished( Request $request , EventRepository $eventRepository,ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' =>  count($this->getUser()->getElector()->getEvent()),
            'currentRoute' => $currentRoute,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),

        ]);

    }

    /**
     * @Route("/eventResultat", name="eventResultat")
     */
    public function showEventTer( Request $request , EventRepository $eventRepository,ElectorRepository $electorRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        $user = $this->getUser();
        return $this->render('users/baseUsers.html.twig', [

            'events' => $user->getElector()->getEvent(),
            'eventNumber' =>  count($this->getUser()->getElector()->getEvent()),
            'currentRoute' => $currentRoute,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),

        ]);

    }


    /**
     * @Route("/eventUser/{id}", name="eventUser_show" , methods={"GET"})
     */
    public function showEv (Event $event, Request $request , EventRepository $eventRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'candidats' =>  $event->getCandidats() ,
            'events' => $eventRepository->findAll(),
            'event' => $event,
            'currentRoute' => $currentRoute,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),

        ]);

    }

    /**
     * @Route("/eventUser/candidat/{id}", name="eventUser_candidat_show" , methods={"GET"})
     */
    public function showCandidat (Candidats $candidat,  Request $request)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'candidat' => $candidat,
            'currentRoute' => $currentRoute,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),

        ]);

    }


    /**
     * @Route("/eventUser/vote/{id}", name="eventUser_vote" , methods={"GET"})
     */
    public function voter (Candidats $candidat,  Request $request)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'candidat' => $candidat,
            'currentRoute' => $currentRoute,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),

        ]);

    }

    /**
     * @Route("/eventUser/resultat/{id}", name="eventUser_result" , methods={"GET"})
     */
    public function result (Candidats $candidat,  Request $request)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'candidat' => $candidat,
            'currentRoute' => $currentRoute,
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),

        ]);

    }


    /**
     * @Route("/note", name="eventUser_note" , methods={"GET"})
     */
    public function note (  Request $request)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),
            'currentRoute' => $currentRoute,

        ]);

    }

    /**
     * @Route("/aide", name="eventUser_aide" , methods={"GET"})
     */
    public function aide (  Request $request)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),
            'currentRoute' => $currentRoute,

        ]);

    }


    /**
     * @Route("/setting", name="eventUser_setting" , methods={"GET"})
     */
    public function setting (  Request $request)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'userPhoto' => $this->getUser()->getElector()->getPhoto(),
            'currentRoute' => $currentRoute,

        ]);

    }

}
