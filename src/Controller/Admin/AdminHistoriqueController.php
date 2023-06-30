<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Historique;
use App\Repository\HistoriqueRepository;
use App\Form\HistoriqueFormType;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\ImageRepository;

class AdminHistoriqueController extends AbstractController
{
    #[Route('/admin/historique', name: 'admin_historique')]
    public function index(HistoriqueRepository $historiquerepo, ImageRepository $imageRepository): Response
    {
        $historique = $historiquerepo->findBy([],['id' => 'ASC']);
        $showHistoriques = array_chunk($historique, 3);

        $images1  = $imageRepository->find(1);
        $images2  = $imageRepository->find(2);

        return $this->render('historique/admin/admin_historique.html.twig', [
            'showHistoriques' => $showHistoriques,
            'images1' => $images1,
            'images2' => $images2,

        ]);
    }


    #[Route('/admin/historique/ajouter', name: 'historique.add')]
    public function AjouterActuRequest(Request $request,  EntityManagerInterface $manager): Response
    {   $historique = new Historique();
        $form_historique = $this->createForm(HistoriqueFormType::class,$historique);
        $form_historique -> handleRequest($request);
    
        if( $form_historique->isSubmitted() && $form_historique->isValid()){
            
            $manager->persist($historique);
            $manager->flush();

            return $this->redirectToRoute('admin_historique',[
            ]);
        }

        return $this->render('historique/admin/ajouter_historique.html.twig', [
            'form_historique' => $form_historique->createView()
        ]);
    }

    #[Route('/admin/historique/{id}', name: 'historique.delete', methods: ['DELETE'])]
    public function delete(Historique $historique, EntityManagerInterface $entityManager, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete'.$historique->getId(), $request->get('_token')))
        {
            $entityManager->remove($historique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_historique');
    }

    #[Route('/admin/historique/{id}', name: 'historique.edit', methods: ['GET', 'POST'])]
    public function ModifierActu(Historique $historique, Request $request, EntityManagerInterface $manager): Response
    {          
        $form_historique = $this->createForm(HistoriqueFormType::class, $historique);
        $form_historique->handleRequest($request);

        if ($form_historique->isSubmitted() && $form_historique->isValid()) {
            $manager->persist($historique);
            $manager->flush();

            // Rediriger vers une page de confirmation ou une autre action
            return $this->redirectToRoute('admin_historique',[
            ]);
        }

        return $this->render('historique/admin/modifier_historique.html.twig', [
            'form_historique' => $form_historique->createView(),
        ]);
    }
}
