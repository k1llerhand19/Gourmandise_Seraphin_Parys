<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Actualites;
use App\Repository\ActualitesRepository;
use App\Form\ActualitesFormType;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ActualitesRepository $actualitesRepo): Response
    {
        $showActualites = $actualitesRepo->findBy([],['id' => 'DESC']);

        return $this->render('accueil/index.html.twig', [
            'showActualites' => $showActualites,
        ]);
    }

    #[Route('/menu', name: 'app_menu')]
    public function menu(): Response
    {
        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }
}
