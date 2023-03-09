<?php

namespace App\UseCase\GetMatchs;

final class Request
{
    public function __construct(
        private readonly ?string $teamUuid
    ){}

    /**
     * @return string|null
     */
    public function getTeamUuid(): ?string
    {
        return $this->teamUuid;
    }
}