<?php

namespace App\UseCase\CreateMatch;

use Symfony\Component\Uid\Uuid;

final class Request
{
    public function __construct(
        private readonly string $name,
        private readonly string $homeTeamId,
        private readonly string $visitorTeamId
    ) {}

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getHomeTeamId(): string
    {
        return $this->homeTeamId;
    }

    /**
     * @return string
     */
    public function getVisitorTeamId(): string
    {
        return $this->visitorTeamId;
    }
}