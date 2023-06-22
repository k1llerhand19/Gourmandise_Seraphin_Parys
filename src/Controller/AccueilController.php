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
    #[Route('/accueil', name: 'app_accueil')]
    public function index(ActualitesRepository $actualitesrepo): Response
    {
        $showactualites = $actualitesrepo->findBy([],['id' => 'DESC']);

        return $this->render('accueil/index.html.twig', [
            'showactualites' => $showactualites,
        ]);
    }
}
