<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexPageController extends AbstractController
{
    /**
     * @Route("/", name="index_page")
     */
    public function index()
    {
        return $this->render('index_page/index.html.twig', [
            'controller_name' => 'IndexPageController',
        ]);
    }

    /**
     * @Route("/success", name="createAcct_success_page")
     */
    public function success()
    {
        return $this->render('index_page/success.html.twig', [
            'controller_name' => 'IndexPageController',
        ]);
    }
}
