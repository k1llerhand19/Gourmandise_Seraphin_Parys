<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,  EntityManagerInterface $manager): Response
    {
        $contact = new Contact();
        $formcontact = $this->createForm(ContactFormType::class, $contact);

        $formcontact->handleRequest($request);

        if( $formcontact->isSubmitted() && $formcontact->isValid()){

            $contact = $formcontact->getData();

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'succes',
                'Votre demande a bien été envoyer'
            );

            return $this->redirectToRoute('app_contact',[
            ]);
        }

        return $this->render('contact/index.html.twig', [
            'formcontact' => $formcontact->createView() ,
        ]);
    }
}
