<?php

namespace App\Controller;

use App\Controller\Admin\CancionCrudController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Usuario;
use App\Entity\CancionUsuario;
use App\Repository\CancionRepository;
use App\Repository\CancionUsuarioRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'app_usuario')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsuarioController.php',
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/guardar/cancion/{id}', name: 'guardar_cancion')]
    public function guardarCancion(int $id, EntityManagerInterface $entityManager, Request $request, CancionRepository $cancionRepository): Response
    {   

        $usuario = $this->getUser();
        $cancion = $cancionRepository->find($id);

        $usuarioCancion = new CancionUsuario();
        $usuarioCancion->setUsuario($usuario);
        $usuarioCancion->setCancion($cancion);

        $entityManager->persist($usuarioCancion);
        $entityManager->flush();

        return $this->redirectToRoute('index');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/borrar/cancion/{id}', name: 'borrar_cancion')]
    public function borrarCancion(int $id, EntityManagerInterface $entityManager, CancionUsuarioRepository $cancionUsuarioRepository): Response
    {   
        $usuario = $this->getUser();
        $usuarioCancion = $cancionUsuarioRepository->findOneBy([
            'usuario' => $usuario,
            'cancion' => $id,
        ]);

        if (!$usuarioCancion) {
            throw $this->createNotFoundException('La relación UsuarioCancion con el ID ' . $id . ' no fue encontrada.');
        }

        $entityManager->remove($usuarioCancion);
        $entityManager->flush();


        return $this->redirectToRoute('index');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/canciones/guardadas', name: 'canciones_guardadas')]
    public function mostrarCancionesGuardadas(CancionUsuarioRepository $cancionUsuarioRepository): Response
    {   
        $usuario = $this->getUser();

        $relacionesUsuario = $cancionUsuarioRepository->findBy(['usuario' => $usuario]);

        $cancionesGuardadas = [];

        foreach ($relacionesUsuario as $relacion) {
            $cancion = $relacion->getCancion();
            if ($cancion) {
                $cancionesGuardadas[] = $cancion;
            }
        }

        return $this->render('Cancion/listaCanciones.html.twig', [
            'canciones' => $cancionesGuardadas,
        ]);
    }

}
