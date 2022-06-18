<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'app_')]
class GameController extends AbstractController
{
    #[Route('/game', name: 'game')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig');
    }

    #[Route('/game/{id}', name: 'game_show')]
    public function show($id): Response
    {
        return $this->render('game/index.html.twig', ['id' => $id]);
    }
}
