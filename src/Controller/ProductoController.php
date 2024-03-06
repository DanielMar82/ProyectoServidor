<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use App\Form\ProductoFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    
    #[Route('/producto/ver', name: 'producto_ver')]
    public function verProductos(ProductoRepository $productoRepository): Response {

        $productos = $productoRepository->findAll();

        return $this->render('Producto/listaProductos.html.twig', [
            
            'productos' => $productos,
        ]);
    }
}
