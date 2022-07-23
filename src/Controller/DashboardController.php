<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(AlbumRepository $albumRepository): Response
    {
        $vinyls = $albumRepository->lastFiveRegistered();
        return $this->render('dashboard/index.html.twig', [
            'vinyls' => $vinyls,
        ]);
    }
}
