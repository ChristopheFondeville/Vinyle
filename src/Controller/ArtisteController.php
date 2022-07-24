<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Form\AddArtisteType;
use App\Repository\ArtisteRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArtisteController extends AbstractController
{
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
}
