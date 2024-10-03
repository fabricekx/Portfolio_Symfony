<?php
// src/Controller/ContactController.php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Form\ContactType;
use App\Service\EncryptionService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private EncryptionService $encryptionService; //injection de dépendances
    private EntityManagerInterface $entityManager;

    public function __construct(EncryptionService $encryptionService, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->encryptionService = $encryptionService;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }










    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
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
            $messageEntity->setDate(new \DateTime());

            $email=$contactData->getEmail();
            // Chiffrement de l'email
        $encryptedEmail = $this->encryptionService->encrypt($email);
            $messageEntity->setEmail($encryptedEmail);
            $messageEntity->setMessage($contactData->getMessage());

            // Persister l'entité dans la base de données
            $entityManager->persist($messageEntity);
            $entityManager->flush();

            // Create the email to send to the admin
            $email = (new Email())
                ->from($email)
                ->to('hendrikx@fabricehendrikx.fr') // Replace with your email
                ->subject('New Contact Message')
                ->text(
                    "Name: " . $contactData->getName() . "\n" .
                    "Company: " . $contactData->getCompany() . "\n" .
                    "Message: " . $contactData->getMessage()
                );

            
            try {
                $mailer->send($email);

            // Create the auto-reply email
            $replyEmail = (new Email())
                ->from('hendrikx@fabricehendrikx.fr') // Replace with your no-reply email
                ->to($contactData->getEmail())
                ->subject('Merci pour votre message')
                ->text('Thank you for contacting us. We will get back to you shortly. 
                Merci de nous avoir contacté. Nous vous réponderons rapidement');

            $mailer->send($replyEmail);

            $this->addFlash('success', 'Votre message a été envoyé, merci');
            }
            catch (TransportExceptionInterface $e) {
                // Log the error to a file or monitoring system
                $this->addFlash('danger', 'Désolé, nous avons rencontré un problème lors de l\'envoi de votre message. Le message a tout de même été enregistré et nous vous répondrons dès que possible.');
                // Si tu veux un debug rapide, tu peux aussi logger ceci : $e->getMessage();
                $logger->error('Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());

            }
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact/get/{id}', name: 'contact_get')]
    public function geContactById(int $id): Response
    {
        $user = $this->entityManager->getRepository(Contact::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Déchiffrement de l'email
        $decryptedEmail = $this->encryptionService->decrypt($user->getEmail());

        return new Response('Email de l\'utilisateur: ' . $decryptedEmail);
    }
}
