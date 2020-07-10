<?php

namespace App\Controller;

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

        ]);

    }

    /**
     * @Route("/eventUser", name="eventUser")
     */
    public function showEvent( Request $request , EventRepository $eventRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [

            'events' => $eventRepository->findAll(),
            'currentRoute' => $currentRoute,

        ]);

    }


    /**
     * @Route("/eventUser/{id}", name="eventUser_show" , methods={"GET"})
     */
    public function showEv ( Request $request , EventRepository $eventRepository)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('users/baseUsers.html.twig', [

            'events' => $eventRepository->findAll(),
            'currentRoute' => $currentRoute,

        ]);

    }

}
