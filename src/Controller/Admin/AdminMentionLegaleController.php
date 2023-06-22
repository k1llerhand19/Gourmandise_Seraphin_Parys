<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMentionLegaleController extends AbstractController
{
    #[Route('/admin/mention_legale', name: 'admin_mention_legale')]
    public function mention_legale(): Response
    {
        return $this->render('mention_legale/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
