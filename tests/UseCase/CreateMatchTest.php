<?php

namespace App\Tests\UseCase;

use App\Domain\Entity\Team;
use App\Infrastructure\Doctrine\Repository\TeamRepository;
use App\Infrastructure\Symfony\Command\CreateMatchCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Uid\Uuid;

class CreateMatchTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testExecute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        /** @var TeamRepository $teamRepository */
        $teamRepository = $this->entityManager->getRepository(Team::class);
        $teams = $teamRepository->findAll();
        if (count($teams) < 2) {
            for ($i = count($teams); $i < 2; $i++) {
                $teamRepository->create(new Team(Uuid::v4(), uniqid("Team-")));
            }
            $teams = $teamRepository->findAll();
        }
        $homeTeam = $teams[0];
        $visitorTeam = $teams[1];

        $command = $application->find(CreateMatchCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            CreateMatchCommand::ARGUMENT_MATCH_NAME => 'matchName',
            CreateMatchCommand::ARGUMENT_HOME_TEAM_ID => $homeTeam->getId(),
            CreateMatchCommand::ARGUMENT_VISITOR_TEAM_ID => $visitorTeam->getId()
        ]);
        $this->assertSame(Command::SUCCESS, $r);
    }

    public function testNotWorkingWithMoreThan255Characters(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        /** @var TeamRepository $teamRepository */
        $teamRepository = $this->entityManager->getRepository(Team::class);
        $teams = $teamRepository->findAll();
        if (count($teams) < 2) {
            for ($i = count($teams); $i < 2; $i++) {
                $teamRepository->create(new Team(Uuid::v4(), uniqid("Team-")));
            }
            $teams = $teamRepository->findAll();
        }
        $homeTeam = $teams[0];
        $visitorTeam = $teams[1];

        $command = $application->find(CreateMatchCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            CreateMatchCommand::ARGUMENT_MATCH_NAME => 'm46vsiOVh8f0d91SRtHxLd6q6L7l3skghubbLohDhdoUiUUMD1tOU8ijuqPV1SDcr4IuWZ6s7zE2nkSZb8n0SBj9uOodybXeHuqVaMDXCIIjcder3piE9ZrxVNUktEgh7fqbPHQhwBYsjjqg4v2vEXVQWUSpu4aMtxrXuqrRlKvsGTc4IqTs6MomFeqOByJB0NTYD3v1kMiR6xUem4BllRAYw67tnWCA2tFCAy3ifOpvI9Rnfvyn8MdBVtVVmyNR',
            CreateMatchCommand::ARGUMENT_HOME_TEAM_ID => $homeTeam->getId(),
            CreateMatchCommand::ARGUMENT_VISITOR_TEAM_ID => $visitorTeam->getId()
        ]);
        $this->assertSame(Command::FAILURE, $r);
    }
}