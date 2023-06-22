<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPlanSiteController extends AbstractController
{
    #[Route('/admin/plan_site', name: 'admin_plan_site')]
    public function plan_site(): Response
    {
        return $this->render('plan_site/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
