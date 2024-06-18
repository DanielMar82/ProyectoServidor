<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Entity\ComentarioCancion;
use App\Entity\ComentarioProducto;
use App\Repository\CancionRepository;
use App\Repository\ComentarioRepository;
use App\Repository\ComentarioCancionRepository;
use App\Repository\ComentarioProductoRepository;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class ComentarioController extends AbstractController
{

    #[IsGranted('ROLE_USER')]
    #[Route('/escribirComentarioProducto', name: 'escribir_comentario_producto')]
    public function escribirComentarioProducto(Request $request, EntityManagerInterface $entityManager, ProductoRepository $productoRepository): Response {

        $contenido = $request->request->get('contenidoComentario');
        $idProducto = $request->request->get('id_producto');

        if (empty($contenido)) {
            $this->addFlash('error', 'El contenido del comentario no puede estar vacío.');
            return $this->redirectToRoute('index');
        }

        $usuarioId = $this->getUser();

        $comentario = new Comentario();
        $comentario->setContenido($contenido);
        $comentario->setTipo('Producto'); 
        $comentario->setUsuario($usuarioId);

        $entityManager->persist($comentario);
        $entityManager->flush();

        $producto = $productoRepository->find($idProducto);

        $comentarioProducto = new ComentarioProducto();
        $comentarioProducto->setComentario($comentario);
        $comentarioProducto->setProducto($producto);

        $entityManager->persist($comentarioProducto);
        $entityManager->flush();

        $producto = $productoRepository->find($idProducto);

        if(!$producto) {
            throw $this->createNotFoundException('El producto no existe');
        }
        

        return $this->render('Producto/productoPagina.html.twig', [
            
            'producto' => $producto,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/escribirComentarioCancion', name: 'escribir_comentario_cancion')]
    public function escribirComentarioCancion(Request $request, EntityManagerInterface $entityManager, CancionRepository $cancionRepository): Response {

        $contenido = $request->request->get('contenidoComentario');
        $idCancion = $request->request->get('id_cancion');

        if (empty($contenido)) {
            $this->addFlash('error', 'El contenido del comentario no puede estar vacío.');
            return $this->redirectToRoute('index');
        }

        $usuarioId = $this->getUser();

        $comentario = new Comentario();
        $comentario->setContenido($contenido);
        $comentario->setTipo('Cancion'); 
        $comentario->setUsuario($usuarioId);

        $entityManager->persist($comentario);
        $entityManager->flush();

        $cancion = $cancionRepository->find($idCancion);

        $comentarioCancion = new ComentarioCancion();
        $comentarioCancion->setComentario($comentario);
        $comentarioCancion->setCancion($cancion);

        $entityManager->persist($comentarioCancion);
        $entityManager->flush();

        $cancion = $cancionRepository->find($idCancion);

        if(!$cancion) {
            throw $this->createNotFoundException('La canción no existe');
        }
        

        return $this->render('Producto/cancionPagina.html.twig', [
            
            'cancion' => $cancion,
        ]);
    }
}
