<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    #[Route('/album/add', name: 'app_album_add')]
    public function index(): Response
    {
        return $this->render('album/add_album.html.twig', [
            'controller_name' => 'AlbumController',
        ]);
    }
}
