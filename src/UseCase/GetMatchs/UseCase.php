<?php

namespace App\UseCase\GetMatchs;

use App\Domain\Repository\MatchGameRepository;

final class UseCase
{
    public function __construct(private readonly MatchGameRepository $matchGameRepository)
    {
    }

    public function execute(Request $request): Response
    {
        return new Response($this->matchGameRepository->findAllByTeamOrNull($request->getTeamUuid()));
    }
}