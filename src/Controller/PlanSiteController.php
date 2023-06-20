<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanSiteController extends AbstractController
{
    #[Route('/plan/site', name: 'app_plan_site')]
    public function index(): Response
    {
        return $this->render('plan_site/index.html.twig', [
            'controller_name' => 'PlanSiteController',
        ]);
    }
}
