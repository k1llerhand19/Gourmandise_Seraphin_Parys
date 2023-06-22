<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Historique;
use App\Repository\HistoriqueRepository;
use App\Form\HistoriqueFormType;

class HistoriqueController extends AbstractController
{
    #[Route('/historique', name: 'app_historique')]
    public function index(HistoriqueRepository $historiquerepo): Response
    {
        $showhistorique = $historiquerepo->findBy([],['id' => 'ASC']);

        return $this->render('historique/index.html.twig', [
            'showhistorique' => $showhistorique,
        ]);
    }
}
