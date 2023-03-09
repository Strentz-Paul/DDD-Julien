<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Player;
use App\Domain\Entity\Team;

interface PlayerRepository
{
    public function create(Player $player): void;

    /**
     * @return array<Player>
     */
    public function findAll(): array;

    /**
     * @param string $uuid
     * @return Player|null
     */
    public function findOneByUuid(string $uuid): ?Player;

    /**
     * @param Player $player
     * @param Team $team
     * @return void
     */
    public function setTeam(Player $player, Team $team): void;
}