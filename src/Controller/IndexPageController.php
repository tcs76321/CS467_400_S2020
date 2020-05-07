<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexPageController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('index_page/index.html.twig', [
            'controller_name' => 'IndexPageController',
        ]);
    }
}
