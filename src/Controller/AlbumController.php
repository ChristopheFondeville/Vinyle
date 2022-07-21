<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AddAlbumType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    #[Route('/album/add', name: 'app_album_add')]
    public function addAlbum(Request $request): Response
    {
        $album = new Album();
        $formAddAlbum = $this->createForm(AddAlbumType::class, $album);
        $formAddAlbum->handleRequest($request);

        return $this->renderForm('album/add_album.html.twig', [
            'formAddAlbum' => $formAddAlbum,
        ]);
    }

    #[Route('/album/edit', name: 'app_album_edit')]
    public function editAlbum(): Response
    {
        return $this->render('album/edit_album.html.twig', [
            'controller_name' => 'Modifier album',
        ]);
    }

    #[Route('/album/delete', name: 'app_album_delete')]
    public function deleteAlbum(): Response
    {
        return $this->render('album/delete_album.html.twig', [
            'controller_name' => 'Supprimer album',
        ]);
    }
}
