<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistroFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistroLoginController extends AbstractController
{
    #[Route('/registro/login', name: 'usuario_registrar' )]
    public function registrar(AuthenticationUtils $authenticationUtils, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {


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
        $session = $request->getSession();

        $error=$authenticationUtils->getLastAuthenticationError();

        $lastUsername=$authenticationUtils->getLastUsername();

        $session->set("nombreUsuario", $lastUsername);


        return $this->render('registro_login/registroLogin.html.twig', [
            'RegistroForm' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
