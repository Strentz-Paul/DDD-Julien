<?php

namespace App\Domain\Repository;

use App\Domain\Entity\MatchGame;

interface MatchGameRepository
{
    public function create(MatchGame $matchGame): void;
}