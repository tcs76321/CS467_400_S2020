<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TribalManagementController extends AbstractController
{
    /**
     * @Route("/tribal/management", name="tribal_management")
     */
    public function index()
    {
        return $this->render('tribal_management/index.html.twig', [
            'controller_name' => 'TribalManagementController',
        ]);
    }
}
