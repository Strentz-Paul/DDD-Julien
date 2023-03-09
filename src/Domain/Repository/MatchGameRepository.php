<?php

namespace App\Domain\Repository;

use App\Domain\Entity\MatchGame;

interface MatchGameRepository
{
    /**
     * @param MatchGame $matchGame
     * @return void
     */
    public function create(MatchGame $matchGame): void;

    /**
     * @param string|null $teamUuid
     * @return array<MatchGame>
     */
    public function findAllByTeamOrNull(?string $teamUuid): array;
}