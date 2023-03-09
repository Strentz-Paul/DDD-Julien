<?php

namespace App\Infrastructure\Symfony\Command;

use App\Domain\Exception\ValidationException;
use App\UseCase\CreateMatch\Request;
use App\UseCase\CreateMatch\UseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: self::COMMAND_NAME,
    description: 'Creates a new Match game.',
    hidden: false
)]
final class CreateMatchCommand extends Command
{
    public const COMMAND_NAME = "app:match:create";
    public const ARGUMENT_MATCH_NAME = 'name';
    public const ARGUMENT_HOME_TEAM_ID = 'home_team_id';
    public const ARGUMENT_VISITOR_TEAM_ID = 'visitor_team_id';

    public function __construct(private readonly UseCase $useCase)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(self::ARGUMENT_MATCH_NAME, InputArgument::REQUIRED, 'The name of the match.');
        $this->addArgument(self::ARGUMENT_HOME_TEAM_ID, InputArgument::REQUIRED, 'The uuid of the home Team.');
        $this->addArgument(self::ARGUMENT_VISITOR_TEAM_ID, InputArgument::REQUIRED, 'The uuid of the visitor Team.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $response = $this->useCase->execute(
                new Request(
                    $input->getArgument(self::ARGUMENT_MATCH_NAME),
                    $input->getArgument(self::ARGUMENT_HOME_TEAM_ID),
                    $input->getArgument(self::ARGUMENT_VISITOR_TEAM_ID)
                )
            );
        } catch (ValidationException $validation) {
            $io->error($validation->getMessage());
            return Command::FAILURE;
        }
        $io->success(
            sprintf(
                'Match game has been created. Id is : %s. The name of the match is %s. The home team is %s and the visitor team is %s',
            $response->getId(),
                $response->getName(),
                $response->getHomeTeam(),
                $response->getVisitorTeam()
            )
        );
        return Command::SUCCESS;
    }
}