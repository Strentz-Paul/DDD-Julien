<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Team;

interface TeamRepository
{
    public function create(Team $team): void;
}