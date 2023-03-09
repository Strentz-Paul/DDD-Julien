<?php

namespace App\UseCase\GetTeams;

use App\Domain\Entity\Team;

final class Response
{
    public function __construct(private readonly array $teams)
    {
    }

    /**
     * @return array<Team>
     */
    public function getTeams(): array
    {
        return $this->teams;
    }
}