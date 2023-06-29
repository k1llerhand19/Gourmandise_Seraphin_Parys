<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


use App\Form\ImageFormType;
use App\Entity\Image;
use App\Repository\ImageRepository;

class AdminGallerieController extends AbstractController
{
    #[Route('/admin/gallerie', name: 'admin_gallerie')]
    public function index(ImageRepository $imagerepo): Response
    {
        $showimage = $imagerepo->findBy([],['id' => 'DESC']);

        return $this->render('gallerie/admin/admin_index.html.twig', [
            'showimage' => $showimage,
        ]);
    }

    #[Route('/admin/gallerie/ajouter', name: 'images.add')]
    public function AjouterImageRequest(Request $request,  EntityManagerInterface $manager): Response
    {   $image = new Image();
        $form_image = $this->createForm(ImageFormType::class,$image);
        $form_image -> handleRequest($request);
    
        if( $form_image->isSubmitted() && $form_image->isValid()){
            
            $manager->persist($image);
            $manager->flush();

            return $this->redirectToRoute('admin_gallerie',[
            ]);
        }


        return $this->render('gallerie/admin/ajouteImages.html.twig', [
            'form_image' => $form_image->createView()
        ]);
    }



    #[Route('/admin/gallerie/{id}', name: 'images.delete', methods: ['DELETE'])]
    public function delete(Image $image, EntityManagerInterface $entityManager, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete'.$image->getId(), $request->get('_token')))
        {
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_gallerie');
    }





    #[Route('/admin/gallerie/{id}', name: 'images.edit', methods: ['GET', 'POST'])]
    public function ModifierActu(Image $image, Request $request, EntityManagerInterface $manager): Response
    {          
        $form_image = $this->createForm(ImageFormType::class, $image);
        $form_image->handleRequest($request);

        if ($form_image->isSubmitted() && $form_image->isValid()) {
            $manager->persist($image);
            $manager->flush();

            // Rediriger vers une page de confirmation ou une autre action
            return $this->redirectToRoute('admin_gallerie',[
            ]);
        }

        return $this->render('gallerie/admin/modifier_Images.html.twig', [
            'form_image' => $form_image->createView(),
        ]);
    }

    
}
