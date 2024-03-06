<?php

namespace App\Controller;

use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EstadisticasController extends AbstractController
{
    
    #[Route('/estadisticas/ver', name: 'estadisticas_ver')]
    #[IsGranted('ROLE_MANAGER', message: 'No tienes permiso para visitar esta página.')]
    public function verEstadisticas(ProductoRepository $productoRepository): Response {

        $productos = $productoRepository->findAll();

        return $this->render('estadisticas/estadisticas.html.twig', [
            
            'productos' => $productos,

        ]);
    }
}
