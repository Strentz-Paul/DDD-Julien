<?php

namespace App\Domain\Entity;

use App\Domain\Exception\ValidationException;
use Symfony\Component\Uid\Uuid;

class Player
{
    private Uuid $id;

    private string $name;

    private ?Team $team;

    /**
     * @throws ValidationException
     */
    public function __construct(Uuid $id, string $name)
    {
        $this->id = $id;
        if (mb_strlen($name) > 255) {
            throw new ValidationException("Name must have less than 255 characters.");
        }
        $this->name = $name;
    }

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
     * @return Team|null
     */
    public function getTeam(): ?Team
    {
        return $this->team;
    }

    /**
     * @param Team $team
     * @return $this
     */
    public function setTeam(Team $team): self
    {
        $this->team = $team;
        $team->addPlayer($this);
        return $this;
    }
}