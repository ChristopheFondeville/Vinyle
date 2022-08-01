<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Form\AddArtisteType;
use App\Repository\AlbumRepository;
use App\Repository\ArtisteRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArtisteController extends AbstractController
{
    #[Route('/artiste/list', name: 'app_artiste_list')]
    public function ListArtist(ArtisteRepository $artisteRepository): Response
    {
        return $this->render('artiste/list_artiste.html.twig', [
            'artiste' => $artisteRepository,
        ]);
    }

    #[Route('/artiste/list/{letter<[a-z]>}', name: 'app_artiste_letter')]
    public function ListLetterArtist(ArtisteRepository $artisteRepository,Request $request): Response
    {
        $letter = $request->get('letter');

        $artistes = $artisteRepository->searchArtist($letter);

;        return $this->render('artiste/list_artiste.html.twig', [
            'artistes' => $artistes,
        ]);
    }

    #[Route('/artiste/show/{id<\d+>}', name: 'app_artiste_show')]
    public function showArtist(Artiste $artiste, AlbumRepository $albumRepository): Response
    {

        $albumsArtist = $albumRepository->albumByArtist($artiste->getId());

        return $this->render('artiste/show_artiste.html.twig', [
            'artiste' => $artiste,
            'albumsArtist' => $albumsArtist,
        ]);
    }

    #[Route('/artiste/add', name: 'app_artiste_add')]
    public function index(Request $request, SluggerInterface $slugger, ArtisteRepository $artisteRepository): Response
    {
        $newArtiste = new Artiste();

        $formAddArtiste = $this->createForm(AddArtisteType::class, $newArtiste);
        $formAddArtiste->handleRequest($request);

        if ($formAddArtiste->isSubmitted() && $formAddArtiste->isValid()) {
            $pictureArtiste = $formAddArtiste->get('picture')->getData();


            if ($pictureArtiste) {

                $originalPictureName = pathinfo($pictureArtiste->getClientOriginalName(), PATHINFO_FILENAME);

                $safePictureName = $slugger->slug($originalPictureName);
                $newPictureName = $safePictureName . '-' . uniqid() . '.' . $pictureArtiste->guessExtension();
                $newPictureName = uniqid() . '.' . $pictureArtiste->guessExtension();

                try {
                    $pictureArtiste->move($this->getParameter('artist_directory'),
                        $newPictureName
                    );
                } catch (FileException $e) {
                    echo 'Exception reçue : ', $e->getMessage(), "\n";
                }

                $newArtiste->setPicture($newPictureName);
            }

            $artisteRepository->add($newArtiste, true);
            $this->addFlash('success', 'Album ajouté');

            return $this->redirectToRoute('app_dashboard');
        }
        return $this->renderForm('artiste/add_artiste.html.twig', [
            'formAddArtiste' => $formAddArtiste,
        ]);
    }

    #[Route('/artiste/edit/{id<\d+>}', name: 'app_artiste_edit')]
    public function editArtiste(Artiste $artiste, Request $request, SluggerInterface $slugger, ArtisteRepository $artisteRepository): Response
    {

        $formEditArtiste = $this->createForm(AddArtisteType::class, $artiste);
        $formEditArtiste->handleRequest($request);

        if ($formEditArtiste->isSubmitted() && $formEditArtiste->isValid()) {
            $pictureArtiste = $formEditArtiste->get('picture')->getData();


            if ($pictureArtiste) {

                $originalPictureName = pathinfo($pictureArtiste->getClientOriginalName(), PATHINFO_FILENAME);

                $safePictureName = $slugger->slug($originalPictureName);
                $newPictureName = $safePictureName . '-' . uniqid() . '.' . $pictureArtiste->guessExtension();
                $newPictureName = uniqid() . '.' . $pictureArtiste->guessExtension();

                try {
                    $pictureArtiste->move($this->getParameter('artist_directory'),
                        $newPictureName
                    );
                } catch (FileException $e) {
                    echo 'Exception reçue : ', $e->getMessage(), "\n";
                }

                $artiste->setPicture($newPictureName);
            }

            $artisteRepository->add($artiste, true);
            $this->addFlash('success', 'Artiste modifié');

            return $this->redirectToRoute('app_dashboard');
        }
        return $this->renderForm('artiste/edit_artiste.html.twig', [
            'formEditArtiste' => $formEditArtiste,
            'artiste' => $artiste,
        ]);
    }
}
