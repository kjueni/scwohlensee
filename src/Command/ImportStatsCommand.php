<?php
namespace App\Command;

use DateTime;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use App\Repository\TeamRepository;
use App\Service\Stats\SFVScheduleCrawler;

class ImportStatsCommand extends Command
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * @param TeamRepository $teamRepository
     */
    public function __construct(TeamRepository $teamRepository)
    {
        $this->setTeamRepository($teamRepository);

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
                    $this->importSchedules();
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

    public function importSchedules()
    {
        $teams = array();

        $this->importScheduleForTeam();
    }

    protected function importScheduleForTeam()
    {
        $crawler = new SFVScheduleCrawler(
            'http://www.football.ch/fvbj/de/Fussballverband-Bern-Jura/Verband-FVBJ/Vereine-FVBJ/Verein-FVBJ.aspx/v-1395/t-36980/ls-16100/sg-47730/a-pt/'
        );

        $games = $crawler->crawl();

        die(var_dump($games));
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
}
