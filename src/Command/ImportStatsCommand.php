<?php
namespace App\Command;

use DateTime;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
//use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use App\Entity\Game;
use App\Entity\GameType;
use App\Entity\Team;
use App\Repository\GameRepository;
use App\Repository\GameTypeRepository;
use App\Repository\TeamRepository;
use App\Service\Stats\SFVScheduleCrawler;

class ImportStatsCommand extends Command
{
    const TEAM_NAME = 'SC Wohlensee';

    /**
     * @var TeamRepository
     */
    private $teamRepository;
    /**
     * @var GameRepository
     */
    private $gameRepository;
    /**
     * @var GameTypeRepository
     */
    private $gameTypeRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ImportStatsCommand constructor.
     * @param EntityManagerInterface $entityManager
     * @param TeamRepository $teamRepository
     * @param GameRepository $gameRepository
     * @param GameTypeRepository $gameTypeRepository
     */
    public function __construct(EntityManagerInterface $entityManager, TeamRepository $teamRepository, GameRepository $gameRepository, GameTypeRepository $gameTypeRepository)
    {
        $this->setEntityManager($entityManager);
        $this->setTeamRepository($teamRepository);
        $this->setGameRepository($gameRepository);
        $this->setGameTypeRepository($gameTypeRepository);

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:import-team-stats')
            ->setDescription('Imports data from the legacy system')
            ->addArgument(
                'types',
                InputArgument::IS_ARRAY,
                'One or more types to import',
                array(
                    'schedules',
                    'tables',
                )
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '',
            'Started import',
            '=========================================',
            '',
        ]);

        $types = $input->getArgument('types');

        foreach ($types as $type) {
            switch ($type) {
                case 'schedules':
                    $this->importSchedules($output);
                    break;
            }
        }

        $output->writeln([
            '',
            '=========================================',
            'Finished import',
            '',
        ]);

        return 0;
    }

    public function importSchedules(OutputInterface $output)
    {
        $teams = $this->getTeamRepository()->findAll();
        $gameTypes = $this->getGameTypeRepository()->findAll();

        foreach ($teams as $team) {
            /** @var Team $team */
            if ($team->getGamesUrl()) {
                $this->importScheduleForTeam($team, $gameTypes, $output);
            }
        }
    }

    /**
     * @param Team $team
     * @param GameType[] $gameTypes
     * @param OutputInterface $output
     */
    protected function importScheduleForTeam(Team $team, array $gameTypes, $output)
    {
        $output->writeln(
            array(
                '',
                sprintf('Started import of games for team %s', $team->getName()),
                '-----------------------------------------',
                '',
            )
        );

        /**
         * @param string $typeName
         * @return GameType|null
         */
        $getGameType = function ($typeName) use ($gameTypes) {
            $gameType = null;

            foreach ($gameTypes as $type) {
                if (strpos($typeName, $type->getName()) !== false) {
                    $gameType = $type;
                    break;
                }
            }

            if ($gameType === null) {
                die($typeName);
            }

            return $gameType;
        };

        $crawler = new SFVScheduleCrawler($team->getGamesUrl());

        try {
            $games = $crawler->crawl();

            /** @var GameRepository $gameRepository */
            $gameRepository = $this->getGameRepository();
            $entityManager = $this->getEntityManager();

            foreach ($games as $gameData) {
                $new = false;

                $gameData['is_away'] = strpos($gameData['home_team'], self::TEAM_NAME) !== false ? false : true;
                $gameData['type'] = $getGameType($gameData['type']);
                $gameData['starts_on'] = $gameData['date'];
                $gameData['team'] = $team;
                $gameData['opponent'] = $gameData['is_away'] ? $gameData['home_team'] : $gameData['away_team'];

                /** @var Game|null $game */
                $game = $gameRepository->findOneBy(
                    array(
                        'team' => $gameData['team'],
                        'startsOn' => $gameData['date'],
                    )
                );

                if ($game === null) {
                    $game = Game::fromArray($gameData);
                    $new = true;
                } else {
                    $game = $gameRepository->hydrate($game, $gameData);
                }

                $entityManager->persist($game);
                $entityManager->flush();

                $output->writeln(
                    array(
                        sprintf(
                            '%s - %s',
                            $new ? 'created' : 'updated',
                            sprintf(
                                '%s - %s (%s)',
                                $team->getName(),
                                $game->getOpponent(),
                                $game->getType()->getName()
                            )
                        ),
                    )
                );
            }

        } catch (\Exception $e) {
            throw $e;
        }

        $output->writeln(
            array(
                '',
                '-----------------------------------------',
                sprintf('Finished import of games for team %s', $team->getName()),
            )
        );
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return TeamRepository
     */
    public function getTeamRepository(): TeamRepository
    {
        return $this->teamRepository;
    }

    /**
     * @param TeamRepository $teamRepository
     */
    public function setTeamRepository(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * @return GameRepository
     */
    public function getGameRepository(): GameRepository
    {
        return $this->gameRepository;
    }

    /**
     * @param GameRepository $gameRepository
     */
    public function setGameRepository(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @return GameTypeRepository
     */
    public function getGameTypeRepository(): GameTypeRepository
    {
        return $this->gameTypeRepository;
    }

    /**
     * @param GameTypeRepository $gameTypeRepository
     */
    public function setGameTypeRepository(GameTypeRepository $gameTypeRepository)
    {
        $this->gameTypeRepository = $gameTypeRepository;
    }
}
