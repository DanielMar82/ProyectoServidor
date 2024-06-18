<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoFormType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class VideoController extends AbstractController
{   

    //Esto ya No es necesario
    // #[Route('/cancion/añadir', name: 'cancion_añadir')]
    // #[IsGranted('ROLE_ADMIN', message: 'No tienes permiso para visitar esta página.')]
    // public function añadirCancion(Request $request, EntityManagerInterface $entityManager): Response {
        
    //     $cancion = new Cancion();

    //     $form = $this->createForm(CancionFormType::class, $cancion);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()){

    //         $entityManager->persist($cancion);
    //         $entityManager->flush();

    //         return new Response(
    //             'Canción añadida'
    //         );
    //     }

    //     return $this->render('Cancion/cancion.html.twig', [
    //         'CancionForm' => $form->createView(),
    //     ]);
    // }

    //Esta ya no se usa
    #[Route('/video/ver', name: 'video_ver')]
    public function verVideos(VideoRepository $videoRepository): Response {

        $videos = $videoRepository->findAll();

        return $this->render('Video/listaVideosTutoriales.html.twig', [
            
            'videos' => $videos,
        ]);
    }


    // TUTORIALES
    #[Route('/video/tutorial/guitarraAcustica/ver', name: 'video_tutorial_guitarraAcustica_ver')]
    public function verTutorialesGuitarraAcustica(VideoRepository $videoRepository): Response {

        $videos = $videoRepository->findBy(['tipo' => 'Tutorial', 'instrumento' => 'GuitarraAcustica']);

        return $this->render('Video/listaVideos.html.twig', [
            
            'videos' => $videos,
        ]);
    }

    #[Route('/video/tutorial/guitarraElectrica/ver', name: 'video_tutorial_guitarraElectrica_ver')]
    public function verTutorialesGuitarraElectrica(VideoRepository $videoRepository): Response {

        $videos = $videoRepository->findBy(['tipo' => 'Tutorial', 'instrumento' => 'GuitarraElectrica']);

        return $this->render('Video/listaVideos.html.twig', [
            
            'videos' => $videos,
        ]);
    }

    #[Route('/video/tutorial/bajo/ver', name: 'video_tutorial_bajo_ver')]
    public function verTutorialesBajo(VideoRepository $videoRepository): Response {

        $videos = $videoRepository->findBy(['tipo' => 'Tutorial', 'instrumento' => 'Bajo']);

        return $this->render('Video/listaVideos.html.twig', [
            
            'videos' => $videos,
        ]);
    }

    #[Route('/video/tutorial/ukelele/ver', name: 'video_tutorial_ukelele_ver')]
    public function verTutorialesUkelele(VideoRepository $videoRepository): Response {

        $videos = $videoRepository->findBy(['tipo' => 'Tutorial', 'instrumento' => 'Ukelele']);

        return $this->render('Video/listaVideos.html.twig', [
            
            'videos' => $videos,
        ]);
    }

    //CURSOS

    #[Route('/video/curso/guitarraAcustica/ver', name: 'video_curso_guitarraAcustica_ver')]
    public function verCursosGuitarraAcustica(VideoRepository $videoRepository): Response {

        $videos = $videoRepository->findBy(['tipo' => 'Curso', 'instrumento' => 'GuitarraAcustica']);

        return $this->render('Video/listaVideos.html.twig', [
            
            'videos' => $videos,
        ]);
    }

    #[Route('/video/curso/guitarraElectrica/ver', name: 'video_curso_guitarraElectrica_ver')]
    public function verCursosGuitarraElectrica(VideoRepository $videoRepository): Response {

        $videos = $videoRepository->findBy(['tipo' => 'Curso', 'instrumento' => 'GuitarraElectrica']);

        return $this->render('Video/listaVideos.html.twig', [
            
            'videos' => $videos,
        ]);
    }

    #[Route('/video/curso/bajo/ver', name: 'video_curso_bajo_ver')]
    public function verCursosBajo(VideoRepository $videoRepository): Response {

        $videos = $videoRepository->findBy(['tipo' => 'Curso', 'instrumento' => 'Bajo']);

        return $this->render('Video/listaVideos.html.twig', [
            
            'videos' => $videos,
        ]);
    }

    #[Route('/video/curso/ukelele/ver', name: 'video_curso_ukelele_ver')]
    public function verCursosUkelele(VideoRepository $videoRepository): Response {

        $videos = $videoRepository->findBy(['tipo' => 'Curso', 'instrumento' => 'Ukelele']);

        return $this->render('Video/listaVideos.html.twig', [
            
            'videos' => $videos,
        ]);
    }

}
