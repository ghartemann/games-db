<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Service\RAWGConnector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[Route('/jeu', name: 'app_game_')]
class GameController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/', name: 'index')]
    public function index(GameRepository $gameRepository, RAWGConnector $RAWGConnector): Response
    {
        $games = $gameRepository->findAll();

        $gameInfos = [];

        foreach ($games as $game) {
            $gameInfos[] = $RAWGConnector->getInfosGame($game->getSlug());
        }

        return $this->render('game/index.html.twig', ['games' => $games, 'gameInfos' => $gameInfos]);
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

    #[Route('/{slug}', name: 'show')]
    public function show(Game $game, RAWGConnector $RAWGConnector): Response
    {
        $gameInfos = $RAWGConnector->getInfosGame($game->getSlug());

        return $this->render('game/show.html.twig', ['game' => $game, 'gameInfos' => $gameInfos]);
    }


}
