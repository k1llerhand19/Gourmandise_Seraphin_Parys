<?php

namespace App\Controller\Admin;

use App\Entity\Actualites;
use App\Repository\ActualitesRepository;
use App\Form\ActualitesFormType;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAccueilController extends AbstractController
{
    #[Route('/admin/accueil', name: 'admin_accueil')]
    public function accueil(ActualitesRepository $actualitesrepo): Response
    {
        $showactualites = $actualitesrepo->findBy([],['id' => 'DESC']);

        return $this->render('accueil/admin/admin_accueil.html.twig', [
            'showactualites' => $showactualites,
        ]);
    }

    #[Route('/admin/accueil/ajouter', name: 'actualites.add')]
    public function AjouterActuRequest(Request $request,  EntityManagerInterface $manager): Response
    {   $actu = new Actualites();
        $form_actu = $this->createForm(ActualitesFormType::class,$actu);
        $form_actu -> handleRequest($request);
    
        if( $form_actu->isSubmitted() && $form_actu->isValid()){
            
            $manager->persist($actu);
            $manager->flush();

            return $this->redirectToRoute('admin_accueil',[
            ]);
        }


        return $this->render('accueil/admin/ajouter_actualites.html.twig', [
            'form_actu' => $form_actu->createView()
        ]);
    }

    #[Route('/admin/accueil/{id}', name: 'actualites.delete', methods: ['DELETE'])]
    public function delete(Actualites $actualites, EntityManagerInterface $entityManager, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete'.$actualites->getId(), $request->get('_token')))
        {
            $entityManager->remove($actualites);
            $entityManager->flush();

            //$this->addFlash('success', "Le serveur a bien été supprimé !");
        }

        return $this->redirectToRoute('admin_accueil');
    }

    #[Route('/admin/accueil/{id}', name: 'actualites.edit', methods: ['GET', 'POST'])]
    public function ModifierActu(Actualites $actualites, Request $request, EntityManagerInterface $manager): Response
    {          
        $form_actu = $this->createForm(ActualitesFormType::class, $actualites);
        $form_actu->handleRequest($request);

        if ($form_actu->isSubmitted() && $form_actu->isValid()) {
            $manager->persist($actualites);
            $manager->flush();

            // Rediriger vers une page de confirmation ou une autre action
            return $this->redirectToRoute('admin_accueil',[
            ]);
        }

        return $this->render('accueil/admin/modifier_actualites.html.twig', [
            'form_actu' => $form_actu->createView(),
        ]);
    }

}
