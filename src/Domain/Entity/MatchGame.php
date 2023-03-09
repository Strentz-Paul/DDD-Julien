<?php

namespace App\Domain\Entity;

use App\Domain\Exception\ValidationException;
use Symfony\Component\Uid\Uuid;

class MatchGame
{
    private Uuid $id;

    private string $name;

    private Team $homeTeam;

    private Team $visitorTeam;

    public function __construct(Uuid $id, string $name, Team $homeTeam, Team $visitorTeam)
    {
        $this->id = $id;
        if (mb_strlen($name) > 255) {
            throw new ValidationException("Name must have less than 255 characters.");
        }
        if ($homeTeam === $visitorTeam) {
            throw new ValidationException("It cannot have match between same team");
        }
        $this->name = $name;
        $this->homeTeam = $homeTeam;
        $this->visitorTeam = $visitorTeam;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return Team
     */
    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    /**
     * @return Team
     */
    public function getVisitorTeam(): Team
    {
        return $this->visitorTeam;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}