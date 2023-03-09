<?php

namespace App\Infrastructure\Symfony\Command;

use App\Domain\Exception\ValidationException;
use App\UseCase\AddPlayerToTeam\Request;
use App\UseCase\AddPlayerToTeam\UseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: self::COMMAND_NAME,
    description: 'Add a player to a team.',
    hidden: false
)]
final class AddPlayerToTeamCommand extends Command
{
    public const COMMAND_NAME = "app:add-player-to-team:create";
    public const ARGUMENT_PLAYER_UUID = 'player_uuid';
    public const ARGUMENT_TEAM_UUID = 'team_uuid';

    public function __construct(private readonly UseCase $useCase)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(self::ARGUMENT_PLAYER_UUID, InputArgument::REQUIRED, 'The uuid of the player.');
        $this->addArgument(self::ARGUMENT_TEAM_UUID, InputArgument::REQUIRED, 'The uuid of the team.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);
        try {
            $response = $this->useCase->execute(
                new Request(
                    $input->getArgument(self::ARGUMENT_PLAYER_UUID),
                    $input->getArgument(self::ARGUMENT_TEAM_UUID)
                )
            );
        } catch (ValidationException $validation) {
            $io->error($validation->getMessage());
            return Command::FAILURE;
        }
        $io->success(
            sprintf(
                'The relation between player and team has been created. Player Id is : %s and the Team Id is : %s',
                $response->getPlayerUuid(),
                $response->getTeamUuid()
        ));
        return Command::SUCCESS;
    }
}