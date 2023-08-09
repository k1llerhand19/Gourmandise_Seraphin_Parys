<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;


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
    public function AjouterImageRequest(Request $request,  EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {   $image = new Image();
        $form_image = $this->createForm(ImageFormType::class,$image);
        $form_image -> handleRequest($request);
    
        if( $form_image->isSubmitted() && $form_image->isValid()){
            
            $brochureFile = $form_image->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $image->setName($newFilename);
            }
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
    public function ModifierActu(Image $image, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {          
        $form_image = $this->createForm(ImageFormType::class, $image);
        $form_image->handleRequest($request);

        if ($form_image->isSubmitted() && $form_image->isValid()) {

            $brochureFile = $form_image->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $image->setName($newFilename);
            }
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
