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
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistroLoginController extends AbstractController
{
    #[Route('/registro/login', name: 'usuario_registrar' )]
    public function registrarLogin(AuthenticationUtils $authenticationUtils, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {


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

            return $this->redirectToRoute('index');
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

    #[Route('/perfil', name: 'perfil_ver' )]
    public function verPerfil(): Response{
        
        return $this->render('registro_login/perfil.html.twig');
    }

    #[Route('/sesion/eliminar', name: 'sesion_eliminar' )]
    public function eliminarSesion(Request $request): Response{
        
        $session = $request->getSession();
        $session->clear();

        return $this->redirectToRoute('homepage');
    }

    #[Route('/cambiarContraseña', name: 'contraseña_cambiar' )]
    public function cambiarContraseña(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher): Response{
    
        $user = $this->getUser();

        if (!$user instanceof Usuario) {
            throw new AccessDeniedException('Acceso denegado.');
        }

        if ($request->isMethod('POST')) {
            $actualPassword = $request->request->get('actualPassword');
            $nuevaPassword = $request->request->get('nuevaPassword');

            if (!$passwordHasher->isPasswordValid($user, $actualPassword)) {
                $this->addFlash('error', 'La contraseña actual es incorrecta.');
                return $this->redirectToRoute('perfil_ver');
            }

            $hashedPassword = $passwordHasher->hashPassword($user, $nuevaPassword);

            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Contraseña cambiada correctamente.');
            return $this->redirectToRoute('perfil_ver');
        }


        return $this->render('registro_login/perfil.html.twig');
    }

    #[Route('/verificarBorrado', name: 'verificar_borrado' )]
    public function verificarBorrado(): Response {

        return $this->render('registro_login/verificarBorrado.html.twig');
    }

    #[Route('/borrar/cuenta', name: 'cuenta_borrar' )]
    public function borrarCuenta(Request $request, EntityManagerInterface $entityManager): Response {

        $session = $request->getSession();
        $user = $this->getUser();
        $session->invalidate();

        $entityManager->remove($user);
        $entityManager->flush();


        $this->addFlash('success', 'Cuenta eliminada correctamente.');

        return $this->redirectToRoute('index');
    }
}
