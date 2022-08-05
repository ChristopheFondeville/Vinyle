<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/profil', name: 'app_user_profil')]
    public function profil(): Response
    {
        return $this->render('user/profil.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
