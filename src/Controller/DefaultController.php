<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home.html.twig', [
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route('/portfolio', name: 'app_portfolio')]
    public function portfolio(): Response
    {
        return $this->render('portfolio.html.twig');
    }

    #[Route('/underConstruction', name: 'app_construction')]
    public function underConstruction(): Response
    {
        return $this->render('underConstruction.html.twig');

    }
}
