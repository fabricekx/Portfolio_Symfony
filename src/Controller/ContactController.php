<?php
// src/Controller/ContactController.php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactData = $form->getData();
            //  dd($contactData);
            // ajout des données en bdd
            // Créer une nouvelle instance de l'entité ContactMessage
            $messageEntity = new Contact();
            $messageEntity->setName($contactData->getName());
            $messageEntity->setCompany($contactData->getCompany());
            $messageEntity->setEmail($contactData->getEmail());
            $messageEntity->setMessage($contactData->getMessage());

            // Persister l'entité dans la base de données
            $entityManager->persist($messageEntity);
            $entityManager->flush();

            // Create the email to send to the admin
            $email = (new Email())
                ->from($contactData->getEmail())
                ->to('admin@example.com') // Replace with your email
                ->subject('New Contact Message')
                ->text(
                    "Name: " . $contactData->getName() . "\n" .
                    "Company: " . $contactData->getCompany() . "\n" .
                    "Message: " . $contactData->getMessage()
                );

            $mailer->send($email);

            // Create the auto-reply email
            $replyEmail = (new Email())
                ->from('noreply@example.com') // Replace with your no-reply email
                ->to($contactData->getEmail())
                ->subject('Thank you for your message')
                ->text('Thank you for contacting us. We will get back to you shortly.');

            $mailer->send($replyEmail);

            $this->addFlash('success', 'Your message has been sent.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
