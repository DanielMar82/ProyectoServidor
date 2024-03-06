<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Form\CancionFormType;
use App\Repository\CancionRepository;
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

    #[Route('/cancion/ver', name: 'cancion_ver')]
    public function verProductos(CancionRepository $cancionRepository): Response {

        $canciones = $cancionRepository->findAll();

        return $this->render('Cancion/listaCanciones.html.twig', [
            
            'canciones' => $canciones,
        ]);
    }
}
