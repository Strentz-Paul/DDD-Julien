<?php

namespace App\UseCase\CreateTeam;

use App\Domain\Entity\Team;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\TeamRepository;
use Exception;
use Symfony\Component\Uid\Uuid;

class UseCase
{
    public function __construct(private readonly TeamRepository $teamRepository)
    {
    }

    /**
     * @throws ValidationException
     */
    public function execute(Request $request): Response
    {
        try {
            $this->teamRepository->create($team = (new Team(Uuid::v4(), $request->getName())));
        } catch (Exception $e) {
            throw new ValidationException("This name already exist");
        }
        return new Response($team->getId());
    }
}