<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Demarche;
use App\Repository\DemarcheRepository;
use App\Form\DemarcheFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class DemarcheController extends AbstractController
{
    #[Route('/demarche', name: 'app_demarche')]
    public function demarche(DemarcheRepository $demarcheRepository): Response
    {
        $showDemarche = $demarcheRepository->findBy([],['id' => 'ASC']);

        return $this->render('demarche/index.html.twig', [
            'showDemarche' => $showDemarche,
        ]);
    }
}
