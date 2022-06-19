<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/jeu', name: 'app_game_')]
class GameController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(GameRepository $gameRepository): Response
    {
        $games = $gameRepository->findAll();

        return $this->render('game/index.html.twig', ['games' => $games]);
    }

    #[Route('/nouveau', name: 'new')]
    public function new(Request $request, GameRepository $gameRepository): Response
    {
        $game = new Game();

        // Create the form, linked with $category
        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);

        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            $gameRepository->add($game, true);

            // Redirect to categories list
            return $this->redirectToRoute('app_game_index');
        }

        // Render the form (best practice)
        return $this->renderForm('game/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', ['game' => $game]);
    }


}
