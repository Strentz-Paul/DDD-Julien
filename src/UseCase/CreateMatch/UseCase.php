<?php

namespace App\UseCase\CreateMatch;

use App\Domain\Entity\MatchGame;
use App\Domain\Entity\Team;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\MatchGameRepository;
use App\Domain\Repository\TeamRepository;
use Exception;
use Symfony\Component\Uid\Uuid;

class UseCase
{
    public function __construct(
        private readonly MatchGameRepository $matchGameRepository,
        private readonly TeamRepository $teamRepository
    ) {}

    /**
     * @throws ValidationException
     */
    public function execute(Request $request): Response
    {
        $homeTeam = $this->teamRepository->findOneByUuid($request->getHomeTeamId());
        if ($homeTeam === null) {
            throw new ValidationException("Home team doesn't exist");
        }
        $visitorTeam = $this->teamRepository->findOneByUuid($request->getVisitorTeamId());
        if ($visitorTeam === null) {
            throw new ValidationException("Visitor team doesn't exist");
        }
        $this->matchGameRepository->create(
            $match = (new MatchGame(
                Uuid::v4(),
                $request->getName(),
                $homeTeam,
                $visitorTeam)
            )
        );
        return new Response(
            $match->getId(),
            $match->getName(),
            $match->getHomeTeam(),
            $match->getVisitorTeam()
        );
    }
}