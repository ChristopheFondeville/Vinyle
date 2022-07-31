<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\ArtisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(AlbumRepository $albumRepository, ArtisteRepository $artisteRepository): Response
    {

        $lastFiveRegistered = $albumRepository->lastFiveRegistered();
        $rand = $albumRepository->randAlbum();
        $artists = $artisteRepository->findAll();
        $vinyls = $albumRepository->findAll();
        /*$totalVinyls = $albumRepository->totalVinyls();*/

        return $this->render('dashboard/index.html.twig', [
            'vinyls' => $vinyls,
            'artists' => $artists,
            'lastFiveRegistered' => $lastFiveRegistered,
            'rands' => $rand,
        ]);
    }
}
