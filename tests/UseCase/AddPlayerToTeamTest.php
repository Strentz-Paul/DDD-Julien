<?php

namespace App\Tests\UseCase;

use App\Domain\Entity\Player;
use App\Domain\Entity\Team;
use App\Domain\Repository\PlayerRepository;
use App\Domain\Repository\TeamRepository;
use App\Infrastructure\Symfony\Command\AddPlayerToTeamCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Uid\Uuid;

class AddPlayerToTeamTest extends KernelTestCase
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

        /**
         * Define player
         */
        /** @var PlayerRepository $playerRepository */
        $playerRepository = $this->entityManager->getRepository(Player::class);
        $players = $playerRepository->findAll();
        if (count($players) === 0) {
            $playerRepository->create(new Player(Uuid::v4(), "Paul"));
            $players = $playerRepository->findAll();
        }
        $player = $players[0];

        /**
         * Define Team
         */
        /** @var TeamRepository $teamRepository */
        $teamRepository = $this->entityManager->getRepository(Team::class);
        $teams = $teamRepository->findAll();
        if (count($teams) === 0) {
            $teamRepository->create(new Team(Uuid::v4(), "team Paul"));
            $teams = $teamRepository->findAll();
        }
        $team = $teams[0];

        $command = $application->find(AddPlayerToTeamCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            AddPlayerToTeamCommand::ARGUMENT_TEAM_UUID => $team->getId(),
            AddPlayerToTeamCommand::ARGUMENT_PLAYER_UUID => $player->getId()
        ]);
        $player = $playerRepository->findOneById($player->getId());
        $this->assertSame(Command::SUCCESS, $r);
        $this->assertSame($team, $player->getTeam());
    }
}