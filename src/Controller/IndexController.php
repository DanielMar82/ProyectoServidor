<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use App\Form\ProductoFormType;
use App\Repository\CancionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IndexController extends AbstractController {

    #[Route('/', name: 'homepage')]
    public function index(CancionRepository $cancionRepository): Response {
        
        $ultimasTresCanciones = $cancionRepository->findUltimasTresCanciones();
        
        return $this->render('index.html.twig', [
            'ultimasTresCanciones' => $ultimasTresCanciones,
        ]);
    }


    //Páginas del Footer
    #[Route('/accesibilidad', name: 'accesibilidad')]
    public function accesibilidad(): Response {
        return $this->render('accesibilidad.html.twig');
    }
    #[Route('/mapaWeb', name: 'mapaWeb')]
    public function mapaWeb(): Response {
        return $this->render('mapaWeb.html.twig');
    }
    #[Route('/sobreNosotros', name: 'sobreNosotros')]
    public function sobreNosotros(): Response {
        return $this->render('sobreNosotros.html.twig');
    }
}