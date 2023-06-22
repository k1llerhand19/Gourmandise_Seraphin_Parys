<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Demarche;
use App\Repository\DemarcheRepository;
use App\Form\DemarcheFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminDemarcheController extends AbstractController
{
    #[Route('/admin/demarche', name: 'admin_demarche')]
    public function demarche(DemarcheRepository $demarcherepo): Response
    {
        $showdemarche = $demarcherepo->findBy([],['id' => 'ASC']);

        return $this->render('demarche/admin/admin_demarche.html.twig', [
            'showdemarche' => $showdemarche,
        ]);
    }

    #[Route('/admin/demarche/ajouter', name: 'demarche.add')]
    public function AjouterActuRequest(Request $request,  EntityManagerInterface $manager): Response
    {   $demarche = new Demarche();
        $form_demarche = $this->createForm(DemarcheFormType::class,$demarche);
        $form_demarche -> handleRequest($request);
    
        if( $form_demarche->isSubmitted() && $form_demarche->isValid()){
            
            $manager->persist($demarche);
            $manager->flush();

            return $this->redirectToRoute('admin_demarche',[
            ]);
        }

        return $this->render('demarche/admin/ajouter_demarche.html.twig', [
            'form_demarche' => $form_demarche->createView()
        ]);
    }



    
    #[Route('/admin/demarche/{id}', name: 'demarche.delete', methods: ['DELETE'])]
    public function delete(Demarche $demarche, EntityManagerInterface $entityManager, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete'.$demarche->getId(), $request->get('_token')))
        {
            $entityManager->remove($demarche);
            $entityManager->flush();

            //$this->addFlash('success', "Le serveur a bien été supprimé !");
        }

        return $this->redirectToRoute('admin_demarche');
    }





    #[Route('/admin/demarche/{id}', name: 'demarche.edit', methods: ['GET', 'POST'])]
    public function ModifierActu(Demarche $demarche, Request $request, EntityManagerInterface $manager): Response
    {          
        $form_demarche = $this->createForm(DemarcheFormType::class, $demarche);
        $form_demarche->handleRequest($request);

        if ($form_demarche->isSubmitted() && $form_demarche->isValid()) {
            $manager->persist($demarche);
            $manager->flush();

            // Rediriger vers une page de confirmation ou une autre action
            return $this->redirectToRoute('admin_demarche',[
            ]);
        }

        return $this->render('demarche/admin/modifier_demarche.html.twig', [
            'form_demarche' => $form_demarche->createView(),
        ]);
    }
}
