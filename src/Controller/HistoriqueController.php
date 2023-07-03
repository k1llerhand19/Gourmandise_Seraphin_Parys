<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Historique;
use App\Repository\HistoriqueRepository;
use App\Form\HistoriqueFormType;

use App\Repository\ImageRepository;

class HistoriqueController extends AbstractController
{
    #[Route('/historique', name: 'app_historique')]
    public function index(HistoriqueRepository $historiqueRepository, ImageRepository $imageRepository): Response
    {
        $historique = $historiqueRepository->findBy([],['id' => 'ASC']);
        $showHistoriques = array_chunk($historique, 3);

        $images1  = $imageRepository->find(1);
        $images2  = $imageRepository->find(2);
        
        return $this->render('historique/index.html.twig', [
            'showHistoriques' => $showHistoriques,
            'images1' => $images1,
            'images2' => $images2,

        ]);
    }

}
