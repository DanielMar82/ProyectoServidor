<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistroFormType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function loggear(AuthenticationUtils $authenticationUtils, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository): Response {
        
        //REGISTRO
        $usuario = new Usuario();
        $form = $this->createForm(RegistroFormType::class, $usuario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $usuario->setPassword(
                $userPasswordHasher->hashPassword(
                    $usuario,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($usuario);
            $entityManager->flush();

            return new Response(
                'Usuario registrado'
            );
        }

        //LOGIN

        $error=$authenticationUtils->getLastAuthenticationError();

        $lastUsername=$authenticationUtils->getLastUsername();

        // $session = $request->getSession();

        // $session->set("nombreUsuario", $lastUsername);

        //return new Response("OH DIOS MIO QUIERO PEGARME UN TIRO");

        return $this->render('registro_login/registroLogin.html.twig', [
            'RegistroForm' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/login/prueba', name: 'prueba_login' )]
    public function eliminarSesion(AuthenticationUtils $authenticationUtils, UsuarioRepository $usuarioRepository, Request $request): Response{
        
        
        $lastUsername=$authenticationUtils->getLastUsername();
        
        return $this->redirectToRoute('app_login');
    }
}
