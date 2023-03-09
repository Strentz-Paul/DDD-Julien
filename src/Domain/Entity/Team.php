<?php

namespace App\Domain\Entity;

use App\Domain\Exception\ValidationException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Uid\Uuid;

class Team
{
    private Uuid $id;

    private string $name;

    private iterable $players;

    public function __construct(Uuid $id, string $name)
    {
        $this->id = $id;
        if (mb_strlen($name) > 255) {
            throw new ValidationException("Name must have less than 255 characters.");
        }
        $this->name = $name;
        $this->players = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
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
     * @return iterable<Player>
     */
    public function getPlayers(): iterable
    {
        return $this->players;
    }

    /**
     * @param Player $player
     * @return $this
     */
    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
        }
        return $this;
    }
}