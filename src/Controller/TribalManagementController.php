<?php

namespace App\Controller;

use App\Entity\Tribe;
use App\Form\ChangeDirectionType;
use App\Form\ChangeFocusType;
use App\Form\ChangeNameType;
use App\Form\RegistrationFormType;
use App\Repository\TribeRepository;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

        $locale = NULL;
        if($tribe){
            $locale = $tribe->getLocation();
        }

//        $North = NULL;
//        if ($locale){
//            $North = $locale->North;
//        }

        return $this->render('tribal_management/index.html.twig', [
            'controller_name' => 'TribalManagementController',
            'user' => $this->getUser(),
            'tribe' => $tribe,
            'Locale' => $locale
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

            return $this->index();
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
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function focus(Request $request, EntityManagerInterface $manager)
    {
        $tribe = NULL;
        if ($this->getUser()){
            $tribe = $this->getUser()->getTribe();
        }

        $form = $this->createForm(ChangeFocusType::class, $tribe);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid())
        {


            $manager->persist($tribe);
            $manager->flush();

            return $this->index();
        }




        return $this->render('tribal_management/focus.html.twig', [
            'controller_name' => 'TribalManagementController',
            'user' => $this->getUser(),
            'tribe' => $tribe,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tribal/changeDirection", name="app_changeDirection")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function direction(Request $request, EntityManagerInterface $manager)
    {
        $tribe = NULL;
        if ($this->getUser()){
            $tribe = $this->getUser()->getTribe();
        }

        $form = $this->createForm(ChangeDirectionType::class, $tribe);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid())
        {


            $manager->persist($tribe);
            $manager->flush();

            return $this->index();
        }




        return $this->render('tribal_management/direction.html.twig', [
            'controller_name' => 'TribalManagementController',
            'user' => $this->getUser(),
            'tribe' => $tribe,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tribal/tutorial", name="tribal_tutorial")
     */
    public function tutorial()
    {
        return $this->render('tribal_management/tutorial.html.twig', [
            'controller_name' => 'TribalManagementController'
        ]);
    }

    /**
     * @Route("/tribal/endturn", name="tribal_endturn")
     * @return Response
     */
    public function endturn()
    {
        $manager = $this->getDoctrine()->getManager();
        $tribe = $this->getUser()->getTribe();

        if($tribe->checkIfAlive())
        {
            $tribe->endDay($tribe, $manager);
            //Redirect back the tribal management page
            return $this->render('tribal_management/endturn.html.twig', [
                'controller_name' => 'TribalManagementController'
            ]);
        }
        else
        {
            return $this->render('tribal_management/dead.html.twig', [
                'controller_name' => 'TribalManagementController'
            ]);
        }
    }

    /**
     * @Route("/tribal/restart", name="tribal_restart")
     * @return Response
     */
    public function restart()
    {
        $manager = $this->getDoctrine()->getManager();
        $tribe = $this->getUser()->getTribe();

        $tribe->reConstruct($manager);

        return $this->render('tribal_management/restart.html.twig', [
            'controller_name' => 'TribalManagementController'
        ]);
    }
}
