<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Form\CancionFormType;
use App\Repository\CancionRepository;
use App\Repository\ComentarioRepository;
use App\Repository\ComentarioCancionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CancionController extends AbstractController
{   

    //Esto ya No es necesario
    #[Route('/cancion/añadir', name: 'cancion_añadir')]
    #[IsGranted('ROLE_ADMIN', message: 'No tienes permiso para visitar esta página.')]
    public function añadirCancion(Request $request, EntityManagerInterface $entityManager): Response {
        
        $cancion = new Cancion();

        $form = $this->createForm(CancionFormType::class, $cancion);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($cancion);
            $entityManager->flush();

            return new Response(
                'Canción añadida'
            );
        }

        return $this->render('Cancion/cancion.html.twig', [
            'CancionForm' => $form->createView(),
        ]);
    }

    #[Route('/listaCanciones/ver', name: 'listaCanciones_ver')]
    public function verListaCanciones(CancionRepository $cancionRepository): Response {

        $canciones = $cancionRepository->findAll();

        return $this->render('Cancion/listaCanciones.html.twig', [
            
            'canciones' => $canciones,
        ]);
    }

    #[Route('/cancion/{id}', name: 'cancion')]
    public function verCancion(CancionRepository $cancionRepository, ComentarioRepository $comentarioRepository, ComentarioCancionRepository $comentarioCancionRepository, int $id): Response {

        $cancion = $cancionRepository->find($id);

        if(!$cancion) {
            throw $this->createNotFoundException('La canción no existe');
        }

        $comentariosCancion = $comentarioCancionRepository->findBy(['cancion' => $cancion]);

        $comentariosConUsuario = [];

        foreach ($comentariosCancion as $comentarioCancion) {
            $comentario = $comentarioCancion->getComentario();
            $usuario = $comentario->getUsuario();
    
            if ($usuario) {
                $comentariosConUsuario[] = [
                    'comentario' => $comentario,
                    'usuario' => $usuario,
                ];
            }
        }

        return $this->render('Cancion/cancionPagina.html.twig', [
            
            'cancion' => $cancion,
            'comentarios' => $comentariosConUsuario,
        ]);
    }

    //LISTAS
    #[Route('/cancion/guitarraAcustica/ver', name: 'cancion_guitarraAcustica_ver')]
    public function verCancionesGuitarraAcusitca(CancionRepository $cancionRepository): Response {

        $canciones = $cancionRepository->findBy(['instrumento' => 'GuitarraAcustica']);

        return $this->render('Cancion/listaCanciones.html.twig', [
            
            'canciones' => $canciones,
        ]);
    }

    #[Route('/cancion/guitarraElectrica/ver', name: 'cancion_guitarraElectrica_ver')]
    public function verCancionesGuitarraElectrica(CancionRepository $cancionRepository): Response {

        $canciones = $cancionRepository->findBy(['instrumento' => 'GuitarraElectrica']);

        return $this->render('Cancion/listaCanciones.html.twig', [
            
            'canciones' => $canciones,
        ]);
    }

    #[Route('/cancion/bajo/ver', name: 'cancion_bajo_ver')]
    public function verCancionesBajo(CancionRepository $cancionRepository): Response {

        $canciones = $cancionRepository->findBy(['instrumento' => 'Bajo']);

        return $this->render('Cancion/listaCanciones.html.twig', [
            
            'canciones' => $canciones,
        ]);
    }

    #[Route('/cancion/ukelele/ver', name: 'cancion_ukelele_ver')]
    public function verCancionesUkelele(CancionRepository $cancionRepository): Response {

        $canciones = $cancionRepository->findBy(['instrumento' => 'Ukelele']);

        return $this->render('Cancion/listaCanciones.html.twig', [
            
            'canciones' => $canciones,
        ]);
    }
}
