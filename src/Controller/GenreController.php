<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    #[Route('/genre', name: 'app_genre_show')]
    public function show(GenreRepository $genreRepository): Response
    {
        return $this->render('genre/show_genre.html.twig', [
            'genres' => $genreRepository->findAll(),
        ]);
    }
}
