<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;

use App\Entity\Etat;
use App\Repository\EtatRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $manager, EtatRepository $etatRepository): Response
    {
        $etat = $etatRepository->find(1);
        $contact = new Contact();
        $contact->setEtat($etat);
        
        $formContact = $this->createForm(ContactFormType::class, $contact);
        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {
            $contact = $formContact->getData();

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre demande a bien été envoyée'
            );

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'formcontact' => $formContact->createView(),
        ]);
    }
}