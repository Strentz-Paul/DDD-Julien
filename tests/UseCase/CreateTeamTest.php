<?php

namespace App\Tests\UseCase;

use App\Domain\Entity\Team;
use App\Infrastructure\Symfony\Command\CreateTeamCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CreateTeamTest extends KernelTestCase
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

        $command = $application->find(CreateTeamCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            CreateTeamCommand::ARGUMENT_TEAM_NAME => uniqid("Team-Paul-")
        ]);
        $this->assertSame(Command::SUCCESS, $r);
    }

    public function testNotWorkingWithMoreThan255Characters(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(CreateTeamCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            CreateTeamCommand::ARGUMENT_TEAM_NAME => 'PaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulJulienJeTeVoisPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaullPaulPaulPaulPaulPaulPaulPaulPaulPaulPaullPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulJulienPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulPaulJulien'
        ]);
        $this->assertSame(Command::FAILURE, $r);
    }

    public function testNotWorkingWithSameName(): void
    {
        $teamRepository = $this->entityManager->getRepository(Team::class);
        $team = $teamRepository->findAll()[0];
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(CreateTeamCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            CreateTeamCommand::ARGUMENT_TEAM_NAME => $team->getName()
        ]);
        $this->assertSame(Command::FAILURE, $r);
    }
}