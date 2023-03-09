<?php

namespace App\Tests\UseCase;

use App\Domain\Entity\Team;
use App\Infrastructure\Doctrine\Repository\TeamRepository;
use App\Infrastructure\Symfony\Command\GetMatchsCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Uid\Uuid;

class GetMatchsTest extends KernelTestCase
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

        $command = $application->find(GetMatchsCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute(array());
        $this->assertSame(Command::SUCCESS, $r);
    }

    public function testWithATeam(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        /** @var TeamRepository $teamRepository */
        $teamRepository = $this->entityManager->getRepository(Team::class);
        $teams = $teamRepository->findAll();
        if (count($teams) < 1) {
            $teamRepository->create(new Team(Uuid::v4(), uniqid()));
            $teams = $teamRepository->findAll();
        }
        $team = $teams[0];

        $command = $application->find(GetMatchsCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute(array(
            GetMatchsCommand::ARGUMENT_TEAM_ID => $team->getId()
        ));
        $this->assertSame(Command::SUCCESS, $r);
    }
}