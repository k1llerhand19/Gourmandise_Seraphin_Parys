<?php

namespace App\Controller\Admin;



use App\Entity\Contact;
use App\Form\admin\AdminContactFormType;
use App\Repository\ContactRepository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;


class AdminContactController extends AbstractController
{
    #[Route('/admin/contact', name: 'admin_contact')]
    public function contact(ManagerRegistry $registry): Response
    {

        $showcontact = $registry->getManager()->getRepository(Contact::class)->createQueryBuilder('c')
            ->select('c.id, c.fullName, c.email, c.subject, c.message, c.createdAt, e.etat as etat')
            ->join('c.Etat', 'e')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();


        return $this->render('contact/admin/admin_contact.html.twig', [
            'showcontact' => $showcontact ,
        ]);
    }

    #[Route('/admin/contact/{id}', name: 'admin_contact.delete', methods: ['DELETE'])]
    public function delete(Contact $contact, EntityManagerInterface $entityManager, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete'.$contact->getId(), $request->get('_token')))
        {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_contact');
    }

    #[Route('/admin/contact/{id}', name: 'admin_contact.edit', methods: ['GET', 'POST'])]
    public function ModifierContact(Contact $contact, Request $request, EntityManagerInterface $manager): Response
    {         
        $form_contact = $this->createForm(AdminContactFormType::class, $contact);
        $form_contact->handleRequest($request);

        if ($form_contact->isSubmitted() && $form_contact->isValid()) {
            $manager->persist($contact);
            $manager->flush();

            // Rediriger vers une page de confirmation ou une autre action
            return $this->redirectToRoute('admin_contact',[
            ]);
        }
        
        return $this->render('contact/admin/modifier_contact.html.twig', [
            'form_contact' => $form_contact->createView(),
        ]);
    }

}
