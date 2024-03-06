<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
