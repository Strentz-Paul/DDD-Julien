<?php

namespace App\UseCase\AddPlayerToTeam;

use App\Domain\Exception\ValidationException;
use App\Domain\Repository\PlayerRepository;
use App\Domain\Repository\TeamRepository;

final class UseCase
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly TeamRepository $teamRepository
    ) {}

    public function execute(Request $request): Response
    {
        $player = $this->playerRepository->findOneByUuid($request->getPlayerId());
        if ($player === null) {
            throw new ValidationException("Player must exist");
        }
        $team = $this->teamRepository->findOneByUuid($request->getTeamId());
        if ($team === null) {
            throw new ValidationException("Team must exist");
        }
        $this->playerRepository->setTeam($player, $team);
        return new Response($team->getid(), $player->getId());
    }
}