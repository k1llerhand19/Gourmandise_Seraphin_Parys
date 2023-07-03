<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Etat;
use App\Repository\EtatRepository;
use App\Form\EtatFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class AdminEtatController extends AbstractController
{ 
    #[Route('/etat', name: 'app_etat')]
    public function index(EtatRepository $etatRepository): Response
    {
        $showEtat = $etatRepository->findBy([],['id' => 'ASC']);

        return $this->render('etat/admin/admin_index.html.twig', [
            'showEtat' => $showEtat,
        ]);
    }

    #[Route('/admin/etat/ajouter', name: 'etat.add')]
    public function AjouterEtatRequest(Request $request,  EntityManagerInterface $manager): Response
    {   $etat = new Etat();
        $form_etat = $this->createForm(EtatFormType::class,$etat);
        $form_etat -> handleRequest($request);
    
        if( $form_etat->isSubmitted() && $form_etat->isValid()){
            
            $manager->persist($etat);
            $manager->flush();

            return $this->redirectToRoute('app_etat',[
            ]);
        }

        return $this->render('etat/admin/ajouter_etat.html.twig', [
            'form_etat' => $form_etat->createView()
        ]);
    }

    #[Route('/admin/etat/{id}', name: 'etat.delete', methods: ['DELETE'])]
    public function delete(Etat $etat, EntityManagerInterface $entityManager, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete'.$etat->getId(), $request->get('_token')))
        {
            $entityManager->remove($etat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etat');
    }

    #[Route('/admin/etat/{id}', name: 'etat.edit', methods: ['GET', 'POST'])]
    public function ModifierActu(Etat $etat, Request $request, EntityManagerInterface $manager): Response
    {          
        $form_etat = $this->createForm(EtatFormType::class, $etat);
        $form_etat->handleRequest($request);

        if ($form_etat->isSubmitted() && $form_etat->isValid()) {
            $manager->persist($etat);
            $manager->flush();

            // Rediriger vers une page de confirmation ou une autre action
            return $this->redirectToRoute('app_etat',[
            ]);
        }

        return $this->render('etat/admin/modifier_etat.html.twig', [
            'form_etat' => $form_etat->createView(),
        ]);
    }
}
