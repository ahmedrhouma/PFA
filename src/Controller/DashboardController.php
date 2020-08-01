<?php

namespace App\Controller;

use App\Entity\Candidats;
use App\Entity\Elector;
use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractController
{


    /**
     * @Route("/", name="Accuiel")
     */
    public function index(Request $request)
    {
        if ($this->getUser()->hasRole('ROLE_ADMIN')) {
            return $this->redirectToRoute('dashboard');
        } else {
            return $this->redirectToRoute('vote_accueil');
        }


    }


    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(Request $request, EventRepository $eventRepository)
    {


        $events = $eventRepository->findAll();
        $json_array_elector = array();
        $json_array_candidat = array();
        $i = 0;
        foreach ($events as $event) {

            $title[$i] = $event->getTitle();
            $statElector[$i] = $event->getStatElector();
            $statCandidat[$i] = $event->getStatCandidat();
            $data_elector = array("name" => $title[$i], "y" => $statElector[$i]);
            $data_candidat = array("name" => $title[$i], "y" => $statCandidat[$i]);
            array_push($json_array_elector, $data_elector);
            array_push($json_array_candidat, $data_candidat);
            $i++;
        }

        $json_array_elector = str_replace(';', ':', preg_replace('/"([a-zA-Z]+[a-zA-Z0-9_]*)":/', '$1;', json_encode($json_array_elector)));
        $json_array_candidat = str_replace(';', ':', preg_replace('/"([a-zA-Z]+[a-zA-Z0-9_]*)":/', '$1;', json_encode($json_array_candidat)));


        // 1. Obtain doctrine manager
        $em = $this->getDoctrine()->getManager();

        // 2. Setup repository of some entity
        $repoArticles = $em->getRepository(Event::class);
        $totalEvent = $repoArticles->createQueryBuilder('a')
            // Filter by some parameter if you want
            // ->where('a.published = 1')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $repoArticles = $em->getRepository(Elector::class);
        $totalElector = $repoArticles->createQueryBuilder('a')
            // Filter by some parameter if you want
            // ->where('a.published = 1')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $repoArticles = $em->getRepository(Candidats::class);
        $totalCandidats = $repoArticles->createQueryBuilder('a')
            // Filter by some parameter if you want
            // ->where('a.published = 1')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();


        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/baseAdmin.html.twig', [
            'currentRoute' => $currentRoute,
            'success' => 0,
            'totalEvent' => $totalEvent,
            'totalElector' => $totalElector,
            'totalCandidats' => $totalCandidats,
            'data_elector' => $json_array_elector,
            'data_candidat' => $json_array_candidat,

        ]);
    }

}
