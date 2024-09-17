<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security): Response
    {
// dd($security->getUser());
        // Vérifier si l'utilisateur est connecté
        if ($security->getUser()) {
            return $this->redirectToRoute('admin');
        }
        // Obtenir l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom d'utilisateur entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
        // dd($lastUsername, $error);
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'logout')]

    public function logout()
    {
        throw new \Exception('Cette méthode ne doit jamais être appelée directement.');
    }
}
