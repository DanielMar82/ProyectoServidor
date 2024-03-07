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
    public function comprar(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response {
        
        // $lastUsername=$authenticationUtils->getLastUsername();

        $session = $request->getSession();

        $nombreUser = $session->get("nombreUsuario");

        // $pedido = new Pedido();
        // $lineaPedido = new LineaPedido();


        return new Response(
            "El usuario con id: ". $nombreUser ." a comprado: "
        );
    }
}
