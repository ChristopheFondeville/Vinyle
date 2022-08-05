<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AddAlbumType;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AlbumController extends AbstractController
{
    #[Route('/album/show/{id<\d+>}', name: 'app_album_show')]
    public function showAlbum(Album $album): Response
    {
        return $this->render('album/show_album.html.twig', [
            'vinyl' => $album,
        ]);
    }

    #[Route('/album/list', name: 'app_album_list')]
    public function ListArtist(AlbumRepository $albumRepository): Response
    {
        return $this->render('album/list_album.html.twig', [
            'album' => $albumRepository,
        ]);
    }

    #[Route('/album/list/{letter<[a-z]>}', name: 'app_album_letter')]
    public function ListLetterArtist(AlbumRepository $albumRepository, Request $request): Response
    {
        $letter = $request->get('letter');

        $albums = $albumRepository->searchAlbum($letter, $this->getUser());;
        return $this->render('album/list_album.html.twig', [
            'albums' => $albums,
        ]);
    }

    #[Route('/album/add', name: 'app_album_add')]
    public function addAlbum(Request $request, SluggerInterface $slugger, AlbumRepository $albumRepository): Response
    {
        $newAlbum = new Album();

        $formAddAlbum = $this->createForm(AddAlbumType::class, $newAlbum);
        $formAddAlbum->handleRequest($request);

        if ($formAddAlbum->isSubmitted() && $formAddAlbum->isValid()) {
            $coverFront = $formAddAlbum->get('cover_front')->getData();
            $coverBack = $formAddAlbum->get('cover_back')->getData();

            if ($coverFront) {

                $originalPictureName = pathinfo($coverFront->getClientOriginalName(), PATHINFO_FILENAME);

                $safePictureName = $slugger->slug($originalPictureName);
                $newPictureName = $safePictureName . '-' . uniqid() . '.' . $coverFront->guessExtension();
                $newPictureName = uniqid() . '.' . $coverFront->guessExtension();

                try {
                    $coverFront->move($this->getParameter('cover_directory'),
                        $newPictureName
                    );
                } catch (FileException $e) {
                    echo 'Exception reçue : ', $e->getMessage(), "\n";
                }

                $newAlbum->setCoverFront($newPictureName);
            }

            if ($coverBack) {
                $originalPictureName = pathinfo($coverBack->getClientOriginalName(), PATHINFO_FILENAME);
                $safePictureName = $slugger->slug($originalPictureName);
                $newPictureName = $safePictureName . '-' . uniqid() . '.' . $coverBack->guessExtension();

                try {
                    $coverBack->move(
                        $this->getParameter('cover_directory'),
                        $newPictureName
                    );
                } catch (FileException $e) {
                    echo 'Exception reçue : ', $e->getMessage(), "\n";
                }

                $newAlbum->setCoverBack($newPictureName);
            }

            $newAlbum->addUser($this->getUser());
            $albumRepository->add($newAlbum, true);

            $this->addFlash('success', 'Album ajouté');

            return $this->redirectToRoute('app_dashboard');
        }
        return $this->renderForm('album/add_album.html.twig', [
            'formAddAlbum' => $formAddAlbum,
        ]);
    }

    #[Route('/album/edit/{id<\d+>}', name: 'app_album_edit')]
    public function editAlbum(Album            $album,
                              Request          $request,
                              SluggerInterface $slugger,
                              AlbumRepository  $albumRepository
    ): Response
    {
        $formEditAlbum = $this->createForm(AddAlbumType::class, $album);
        $formEditAlbum->handleRequest($request);

        if ($formEditAlbum->isSubmitted() && $formEditAlbum->isValid()) {
            $coverFront = $formEditAlbum->get('cover_front')->getData();
            $coverBack = $formEditAlbum->get('cover_back')->getData();

            if ($coverFront) {

                $originalPictureName = pathinfo($coverFront->getClientOriginalName(), PATHINFO_FILENAME);

                $safePictureName = $slugger->slug($originalPictureName);
                $newPictureName = $safePictureName . '-' . uniqid() . '.' . $coverFront->guessExtension();
                $newPictureName = uniqid() . '.' . $coverFront->guessExtension();

                try {
                    $coverFront->move($this->getParameter('cover_directory'),
                        $newPictureName
                    );
                } catch (FileException $e) {
                    echo 'Exception reçue : ', $e->getMessage(), "\n";
                }

                $album->setCoverFront($newPictureName);
            }

            if ($coverBack) {
                $originalPictureName = pathinfo($coverBack->getClientOriginalName(), PATHINFO_FILENAME);
                $safePictureName = $slugger->slug($originalPictureName);
                $newPictureName = $safePictureName . '-' . uniqid() . '.' . $coverBack->guessExtension();

                try {
                    $coverBack->move(
                        $this->getParameter('cover_directory'),
                        $newPictureName
                    );
                } catch (FileException $e) {
                    echo 'Exception reçue : ', $e->getMessage(), "\n";
                }

                $album->setCoverBack($newPictureName);
            }

            $albumRepository->add($album, true);

            $this->addFlash('success', 'Album modifié');

            return $this->redirectToRoute('app_album_show', [
                'id' => $album->getId(),
            ]);
        }

        return $this->renderform('album/edit_album.html.twig', [
            'album' => $album,
            'formEditAlbum' => $formEditAlbum,
        ]);
    }

    #[Route('/album/delete/{id<\d+>}', name: 'app_album_delete', methods: ['GET'])]
    public function deleteAlbum(Album $album, AlbumRepository $albumRepository): Response
    {
        $albumRepository->remove($album, true);
        if ($album->getCoverFront()) {
            $coverFront = $this->getParameter('cover_directory') . '/' . $album->getCoverFront();
            unlink($coverFront);
        }
        if ($album->getCoverBack()) {
            $coverBack = $this->getParameter('cover_directory') . '/' . $album->getCoverBack();
            unlink($coverBack);
        }

        $this->addFlash('success', 'le vinyle a bien été supprimé');

        return $this->redirectToRoute('app_dashboard');
    }
}
