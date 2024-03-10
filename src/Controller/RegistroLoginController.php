<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistroFormType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
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

        $error=$authenticationUtils->getLastAuthenticationError();

        $lastUsername=$authenticationUtils->getLastUsername();

        $session = $request->getSession();

        $session->set("nombreUsuario", $lastUsername);

        return $this->render('registro_login/registroLogin.html.twig', [
            'RegistroForm' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/sesion/ver', name: 'sesion_ver' )]
    public function verSesion(UsuarioRepository $usuarioRepository, Request $request): Response{
        $session = $request->getSession();

        $correoDelUsuario = $session->get("nombreUsuario");

        $user = $usuarioRepository->findOneBy(['email' => $correoDelUsuario]);
        $idUsuario = $user->getId();

        $carrito = $session->get('carrito', []);
        $primeroCarrito = array_key_first($carrito);

        return new Response("El correo del usuario es ". $correoDelUsuario. " con id ". $idUsuario ." con carrito: ".$primeroCarrito);
    }

    #[Route('/sesion/eliminar', name: 'sesion_eliminar' )]
    public function eliminarSesion(UsuarioRepository $usuarioRepository, Request $request): Response{
        
        

        return new Response("Sesion eliminada");
    }
}
