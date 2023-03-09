<?php

namespace App\UseCase\AddPlayerToTeam;

use Symfony\Component\Uid\Uuid;

final class Request
{
    public function __construct(
        private readonly string $playerId,
        private readonly string $teamId
    ) {}

    /**
     * @return Uuid
     */
    public function getPlayerId(): Uuid
    {
        return Uuid::fromString($this->playerId);
    }

    /**
     * @return Uuid
     */
    public function getTeamId(): Uuid
    {
        return Uuid::fromString($this->teamId);
    }
}