<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexPageController extends AbstractController
{
    /**
     * @Route("/index", name="index_page")
     */
    public function index()
    {
        return $this->render('index_page/index.html.twig', [
            'controller_name' => 'IndexPageController',
        ]);
    }
}
