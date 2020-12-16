<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\CrudControllerInterface;

class WoodController extends AbstractController
{
    /**
     * @Route("/", name="wood_home")
     */
    public function index(): Response
    {
        return $this->render('wood/index.html.twig', [
            'controller_name' => 'WoodController',
        ]);
    }

    /**
     * @Route("/about", name="wood_about")
     */
    public function about(): Response
    {
        return $this->render('wood/about.html.twig');
    }
}
