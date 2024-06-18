<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use App\Repository\ComentarioProductoRepository;
use App\Repository\ComentarioRepository;
use App\Form\ProductoFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class ProductoController extends AbstractController
{

    //Esto ya No es necesario
    #[Route('/producto/crear', name: 'producto_crear')]
    #[IsGranted('ROLE_ADMIN', message: 'No tienes permiso para visitar esta página.')]
    public function crearProducto(Request $request, EntityManagerInterface $entityManager): Response {

        $producto = new Producto();

        $form = $this->createForm(ProductoFormType::class, $producto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($producto);
            $entityManager->flush();

            return new Response(
                'Producto creado'
            );
        }

        return $this->render('Producto/producto.html.twig', [
            'ProductoForm' => $form->createView(),
        ]);
    }
    //

    #[Route('/tienda', name: 'tienda')]
    public function verProductos(ProductoRepository $productoRepository): Response {

        $productos = $productoRepository->findAll();

        return $this->render('Producto/listaProductos.html.twig', [
            
            'productos' => $productos,
        ]);
    }
    
    #[Route('/tienda/instrumentos', name: 'tienda_instrumentos')]
    public function verProductosInstrumentos(ProductoRepository $productoRepository): Response {

        $productos = $productoRepository->findBy(['seccion' => 'Instrumento']);

        return $this->render('Producto/listaProductos.html.twig', [
            
            'productos' => $productos,
        ]);
    }
    #[Route('/tienda/accesorios', name: 'tienda_accesorios')]
    public function verProductosAccesorios(ProductoRepository $productoRepository): Response {

        $productos = $productoRepository->findBy(['seccion' => 'Accesorio']);

        return $this->render('Producto/listaProductos.html.twig', [
            
            'productos' => $productos,
        ]);
    }
    #[Route('/tienda/libros', name: 'tienda_libros')]
    public function verProductosLibros(ProductoRepository $productoRepository): Response {

        $productos = $productoRepository->findBy(['seccion' => 'Libro']);

        return $this->render('Producto/listaProductos.html.twig', [
            
            'productos' => $productos,
        ]);
    }
    #[Route('/tienda/sonidoYAudio', name: 'tienda_sonidoYAudio')]
    public function verProductosSonidoYAudio(ProductoRepository $productoRepository): Response {

        $productos = $productoRepository->findBy(['seccion' => 'SonidoYAudio']);

        return $this->render('Producto/listaProductos.html.twig', [
            
            'productos' => $productos,
        ]);
    }

    #[Route('/producto/{id}', name: 'producto')]
    public function verProducto(ProductoRepository $productoRepository, ComentarioRepository $comentarioRepository, ComentarioProductoRepository $comentarioProductoRepository, int $id): Response {

        $producto = $productoRepository->find($id);

        if(!$producto) {
            throw $this->createNotFoundException('El producto no existe');
        }

        $comentariosProducto = $comentarioProductoRepository->findBy(['producto' => $producto]);

        $comentariosConUsuario = [];

        foreach ($comentariosProducto as $comentarioProducto) {
            $comentario = $comentarioProducto->getComentario();
            $usuario = $comentario->getUsuario();
    
            if ($usuario) {
                $comentariosConUsuario[] = [
                    'comentario' => $comentario,
                    'usuario' => $usuario,
                ];
            }
        }

        return $this->render('Producto/productoPagina.html.twig', [
            
            'producto' => $producto,
            'comentarios' => $comentariosConUsuario,
        ]);
    }
}
