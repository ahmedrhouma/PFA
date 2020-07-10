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

        return $this->render('users/baseUsers.html.twig', [
            'currentRoute' => $currentRoute,
            'eventNumber' =>  count($this->getUser()->getElector()->getEvent()),

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
            'currentRoute' => $currentRoute

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
            'currentRoute' => $currentRoute

        ]);

    }

    /**
     * @Route("/eventUser/vote/{id}", name="eventUser_result" , methods={"GET"})
     */
    public function result (Candidats $candidat,  Request $request)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [
            'candidat' => $candidat,
            'currentRoute' => $currentRoute

        ]);

    }

}
