<?php

namespace App\UseCase\AddPlayerToTeam;

use Symfony\Component\Uid\Uuid;

final class Response
{
    public function __construct(
        private readonly Uuid $teamUuid,
        private readonly Uuid $playerUuid
    ){}

    /**
     * @return Uuid
     */
    public function getTeamUuid(): Uuid
    {
        return $this->teamUuid;
    }

    /**
     * @return Uuid
     */
    public function getPlayerUuid(): Uuid
    {
        return $this->playerUuid;
    }
}