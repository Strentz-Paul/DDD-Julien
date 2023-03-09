<?php

namespace App\UseCase\CreateMatch;

use Symfony\Component\Uid\Uuid;

class Response
{
    public function __construct(
        private readonly Uuid $id,
        private readonly string $name,
        private readonly string $homeTeam,
        private readonly string $visitorTeam
    ) {}

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

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
    public function getHomeTeam(): string
    {
        return $this->homeTeam;
    }

    /**
     * @return string
     */
    public function getVisitorTeam(): string
    {
        return $this->visitorTeam;
    }
}