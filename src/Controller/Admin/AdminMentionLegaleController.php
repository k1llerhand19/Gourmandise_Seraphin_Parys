<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Mentionlegale;
use App\Repository\MentionlegaleRepository;
use App\Form\MentionlegaleFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminMentionLegaleController extends AbstractController
{
    #[Route('/admin/mention_legale', name: 'admin_mention_legale')]
    public function mention_legale(MentionlegaleRepository $mentionlegalerepo): Response
    {
        $showmentionlegale = $mentionlegalerepo->findBy([],['id' => 'ASC']);

        return $this->render('mention_legale/admin/admin_mention_legale.html.twig', [
            'showmentionlegale' => $showmentionlegale,
        ]);
    }

    #[Route('/admin/mention_legale/ajouter', name: 'mention_legale.add')]
    public function Ajoutermention_legaleRequest(Request $request,  EntityManagerInterface $manager): Response
    {   $mentionlegale = new Mentionlegale();
        $form_mentionlegale = $this->createForm(MentionlegaleFormType::class,$mentionlegale);
        $form_mentionlegale -> handleRequest($request);
    
        if( $form_mentionlegale->isSubmitted() && $form_mentionlegale->isValid()){
            
            $manager->persist($mentionlegale);
            $manager->flush();

            return $this->redirectToRoute('admin_mention_legale',[
            ]);
        }

        return $this->render('mention_legale/admin/ajouter_mention_legale.html.twig', [
            'form_mentionlegale' => $form_mentionlegale->createView()
        ]);
    }

    #[Route('/admin/mention_legale/{id}', name: 'mention_legale.delete', methods: ['DELETE'])]
    public function delete(Mentionlegale $mentionlegale, EntityManagerInterface $entityManager, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete'.$mentionlegale->getId(), $request->get('_token')))
        {
            $entityManager->remove($mentionlegale);
            $entityManager->flush();

            //$this->addFlash('success', "Le serveur a bien été supprimé !");
        }

        return $this->redirectToRoute('admin_mention_legale');
    }

    #[Route('/admin/mention_legale/{id}', name: 'mention_legale.edit', methods: ['GET', 'POST'])]
    public function ModifierActu(Mentionlegale $mentionlegale, Request $request, EntityManagerInterface $manager): Response
    {          
        $form_mentionlegale = $this->createForm(MentionlegaleFormType::class, $mentionlegale);
        $form_mentionlegale->handleRequest($request);

        if ($form_mentionlegale->isSubmitted() && $form_mentionlegale->isValid()) {
            $manager->persist($mentionlegale);
            $manager->flush();

            // Rediriger vers une page de confirmation ou une autre action
            return $this->redirectToRoute('admin_mention_legale',[
            ]);
        }

        return $this->render('mention_legale/admin/modifier_mention_legale.html.twig', [
            'form_mentionlegale' => $form_mentionlegale->createView(),
        ]);
    }
}
