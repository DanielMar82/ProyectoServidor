<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function loggear(AuthenticationUtils $authenticationUtils, Request $request): Response {
        
        $session = $request->getSession();

        $error=$authenticationUtils->getLastAuthenticationError();

        $lastUsername=$authenticationUtils->getLastUsername();

        $session->set("nombreUsuario", $lastUsername);

        return $this->render('Login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
