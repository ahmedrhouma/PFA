<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index( Request $request)
    {

        $currentRoute = $request->attributes->get('_route');
        return $this->render('admins/dashboard/dashboard.html.twig', [
            'currentRoute' => $currentRoute
        ]);
    }

}
