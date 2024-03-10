<?php

namespace App\Controller;

use App\Entity\LineaPedido;
use App\Entity\Pedido;
use App\Entity\Producto;
use App\Repository\ProductoRepository;
use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ComprarController extends AbstractController
{
    #[Route('/comprar', name: 'app_comprar')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ComprarController.php',
        ]);
    }

    #[Route('/tienda', name: 'enviar_tienda')]
    public function enviarTienda(): Response {

        return $this->render('Comprar/tienda.html.twig');
    }

    #[Route('/comprar/carrito', name: 'comprar_carrito')]
    public function comprar(ProductoRepository $productoRepository, UsuarioRepository $usuarioRepository, AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response {
        
        // $lastUsername=$authenticationUtils->getLastUsername();

        $session = $request->getSession();

        $correoUsuario = $session->get("nombreUsuario");

        $carrito = $session->get('carrito', []);

        $usuario = $usuarioRepository->findOneBy(['email' => $correoUsuario]);
        $idUsuario = $usuario->getId();
        //$nombreUsuario = $usuario->getNombre();

        $pedido = new Pedido();
        $pedido->setUsuario($usuario);

        foreach($carrito as $productoEnCarrito){

            $producto = $productoRepository->find($productoEnCarrito['id']);

            $lineaPedido = new LineaPedido();
            $lineaPedido->setPedidos($pedido);
            $lineaPedido->setProducto($producto);
            $entityManager->persist($lineaPedido);
        }

        $entityManager->persist($pedido);
        $entityManager->flush();

        $carrito = $session->set('carrito', []);


        return $this->redirectToRoute('carrito_ver');
    }
}
