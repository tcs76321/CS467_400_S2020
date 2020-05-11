<?php

namespace App\Controller;

use App\Entity\Tribe;
use App\Form\ChangeNameType;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class TribalManagementController extends AbstractController
{
    /**
     * @Route("/tribal/management", name="tribal_management")
     */
    public function index()
    {
        $tribe = NULL;
        if ($this->getUser()){
            $tribe = $this->getUser()->getTribe();
        }

        return $this->render('tribal_management/index.html.twig', [
            'controller_name' => 'TribalManagementController',
            'user' => $this->getUser(),
            'tribe' => $tribe
        ]);
    }

    /**
     * @Route("/tribal/changeName", name="app_changeName")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function name(Request $request, EntityManagerInterface $manager)
    {
        $tribe = NULL;
        if ($this->getUser()){
            $tribe = $this->getUser()->getTribe();
        }

        $form = $this->createForm(ChangeNameType::class, $tribe);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid())
        {


            $manager->persist($tribe);
            $manager->flush();

            return $this->render('tribal_management/index.html.twig', [
                'controller_name' => 'TribalManagementController',
                'user' => $this->getUser(),
                'tribe' => $tribe
            ]);
        }




        return $this->render('tribal_management/name.html.twig', [
            'controller_name' => 'TribalManagementController',
            'user' => $this->getUser(),
            'tribe' => $tribe,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tribal/changeFocus", name="app_changeFocus")
     */
    public function focus()
    {
        $tribe = NULL;
        if ($this->getUser()){
            $tribe = $this->getUser()->getTribe();
        }

        return $this->render('tribal_management/focus.html.twig', [
            'controller_name' => 'TribalManagementController',
            'user' => $this->getUser(),
            'tribe' => $tribe
        ]);
    }

    /**
     * @Route("/tribal/changeDirection", name="app_changeDirection")
     */
    public function direction()
    {
        $tribe = NULL;
        if ($this->getUser()){
            $tribe = $this->getUser()->getTribe();
        }

        return $this->render('tribal_management/direction.html.twig', [
            'controller_name' => 'TribalManagementController',
            'user' => $this->getUser(),
            'tribe' => $tribe
        ]);
    }
}
