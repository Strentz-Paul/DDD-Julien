<?php

namespace App\Infrastructure\Symfony\Command;

use App\UseCase\GetMatchs\Request;
use App\UseCase\GetMatchs\UseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: self::COMMAND_NAME,
    description: 'Display Matchs.',
    hidden: false
)]
final class GetMatchsCommand extends Command
{
    public const COMMAND_NAME = "app:match:list";
    public const ARGUMENT_TEAM_ID = "team_id";

    public function __construct(private readonly UseCase $useCase)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(self::ARGUMENT_TEAM_ID, InputArgument::OPTIONAL, 'The id of a team.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->useCase->execute(new Request($input->getArgument(self::ARGUMENT_TEAM_ID)));

        $table = new Table($output);
        $rows = array();
        foreach ($response->getMatchs() as $match) {
            $rows[] = array($match->getId(), $match->getName(), $match->getHomeTeam(), $match->getVisitorTeam());
        }
        $table
            ->setHeaders(['Id', 'Name', 'Home Team', 'Visitor Team'])
            ->setRows($rows);
        $table->render();
        return Command::SUCCESS;
    }
}