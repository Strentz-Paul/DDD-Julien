<?php

namespace App\UseCase\GetMatchs;

use App\Domain\Entity\MatchGame;

final class Response
{
    public function __construct(private readonly array $matchs)
    {
    }

    /**
     * @return array<MatchGame>
     */
    public function getMatchs(): array
    {
        return $this->matchs;
    }
}