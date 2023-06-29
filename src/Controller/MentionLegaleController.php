<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Mentionlegale;
use App\Repository\MentionlegaleRepository;
use App\Form\MentionlegaleFormType;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MentionLegaleController extends AbstractController
{
    #[Route('/mention/legale', name: 'app_mention_legale')]
    public function index(MentionlegaleRepository $mentionlegaleRepository): Response
    {
        $showMentionLegale = $mentionlegaleRepository->findBy([],['id' => 'ASC']);

        return $this->render('mention_legale/index.html.twig', [
            'showMentionLegale' => $showMentionLegale,
        ]);
    }
}
