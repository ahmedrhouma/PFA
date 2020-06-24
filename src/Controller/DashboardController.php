<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="tableau_board")
     */
    public function index()
    {

        return $this->render('admins/dashboard/dashboard.html.twig');
    }

}
