<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ImageFormType;
use App\Entity\Image;


use App\Repository\ImageRepository;

class GallerieController extends AbstractController
{
    #[Route('/gallerie', name: 'app_gallerie')]
    public function index(ImageRepository $imagerepo): Response
    {
        $showimage = $imagerepo->findBy([],['id' => 'DESC']);

        return $this->render('gallerie/index.html.twig', [
            'showimage' => $showimage,
        ]);
    }

    #[Route('gallerie/ajouter', name: 'images.add')]
    public function AjouterAlimRequest(Request $request,  EntityManagerInterface $manager): Response
    {   $image = new Image();
        $form_image = $this->createForm(ImageFormType::class,$image);
        $form_image -> handleRequest($request);
    
        if( $form_image->isSubmitted() && $form_image->isValid()){
            
            $manager->persist($image);
            $manager->flush();

            return $this->redirectToRoute('app_gallerie',[
            ]);
        }


        return $this->render('gallerie/ajouteImages.html.twig', [
            'form_image' => $form_image->createView()
        ]);
    }
}
