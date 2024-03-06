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

class RegistroController extends AbstractController
{

    /*#[Route('/registrar', name: 'usuario_registrar' )]
    public function registrar(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {

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


        return $this->render('Registro/registro.html.twig', [
            'RegistroForm' => $form->createView(),
        ]);
    }*/

    #[Route('/registrar', name: 'usuario_registrar' )]
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


        return $this->render('Registro/registro.html.twig', [
            'RegistroForm' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }


    #[Route('/registrar/admin', name: 'administrador_registrar' )]
    #[IsGranted('ROLE_ADMIN', message: 'No tienes permiso para visitar esta página.')]
    public function registrarAdmin(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {

        $administrador = new Usuario();
        $form = $this->createForm(RegistroFormType::class, $administrador);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $administrador->setPassword(
                $userPasswordHasher->hashPassword(
                    $administrador,
                    $form->get('plainPassword')->getData()
                )
            );

            $rol[] = "ROLE_ADMIN";
            $administrador->setRoles($rol);

            $entityManager->persist($administrador);
            $entityManager->flush();

            return new Response(
                'Administrador registrado'
            );
        }

        return $this->render('Registro/registro.html.twig', [
            'RegistroForm' => $form->createView(),
        ]);
    }

    #[Route('/registrar/manager', name: 'manager_registrar' )]
    #[IsGranted('ROLE_ADMIN', message: 'No tienes permiso para visitar esta página.')]
    public function registrarManager(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {

        $manager = new Usuario();
        $form = $this->createForm(RegistroFormType::class, $manager);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->setPassword(
                $userPasswordHasher->hashPassword(
                    $manager,
                    $form->get('plainPassword')->getData()
                )
            );

            $rol[] = "ROLE_MANAGER";
            $manager->setRoles($rol);

            $entityManager->persist($manager);
            $entityManager->flush();

            return new Response(
                'Manager registrado'
            );
        }

        return $this->render('Registro/registro.html.twig', [
            'RegistroForm' => $form->createView(),
        ]);
    }
}
