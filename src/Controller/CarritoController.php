<?php

namespace App\Controller;

use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CarritoController extends AbstractController
{
    #[Route('/carrito/ver', name: 'carrito_ver')]
    public function verCarrito(SessionInterface $session): Response{

        $carrito = $session->get('carrito', []);

        return $this->render('carrito/carrito.html.twig', [
            'carrito' => $carrito
        ]);
    }

    #[Route('/carrito/agregar', name: 'carrito_agregar')]
    public function agregarAlCarrito(Request $request, SessionInterface $session, ProductoRepository $productoRepository): Response{

        $carrito = $session->get('carrito', []);

        $productoId = $request->request->get('id_producto');

        $producto = $productoRepository->find($productoId);

        $carrito[$productoId] = [
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
            'cantidad' => $producto->getCantidad(),
            'imagen' => $producto->getRutaImagen(),
        ];

        $session->set('carrito', $carrito);

        return $this->redirectToRoute('tienda');
    }

    #[Route('/carrito/eliminar', name: 'carrito_eliminar')]
    public function eliminarCarrito(SessionInterface $session): Response{

        $carrito = $session->set('carrito', []);

        return $this->render('carrito/carrito.html.twig',[
            'carrito' => $carrito
        ]);
    }
}
