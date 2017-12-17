<?php
namespace App\Command;

use DateTime;

use Aws\S3\S3Client;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Entity\Employee;
use App\Entity\EmployeeType;
use App\Entity\Player;
use App\Entity\PlayerPosition;
use App\Entity\Team;
use App\Service\Import\Import;

class ImportLegacyDataCommand extends Command
{
    const BASE_URL = 'http://scwohlensee.ch/export';
    const BASE_PATH_PICTURES = 'pictures/';
    const BUCKET_NAME = 'scwohlensee';

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var S3Client
     */
    protected $s3Client;

    /**
     * @param EntityManagerInterface $entityManager
     * @param S3Client $s3Client
     */
    public function __construct(EntityManagerInterface $entityManager, S3Client $s3Client)
    {
        $this->entityManager = $entityManager;
        $this->s3Client = $s3Client;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:import-legacy-data')
            ->setDescription('Imports data from the legacy system')
            ->addArgument(
                'types',
                InputArgument::IS_ARRAY,
                'One or more types to import',
                array(
                    'employee-types',
                    'employees',
                    'positions',
                    'players',
                    'teams',
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
            $output->writeln(
                array(
                    '',
                    sprintf('Started import of %s', $type),
                    '-----------------------------------------',
                    '',
                )
            );

            switch ($type) {

                case 'employee-types':
                    $this->importEmployeeTypes($output);
                    break;

                case 'employees':
                    $this->importEmployees($output);
                    break;
                case 'players':
                    $this->importPlayers($output);
                    break;
                case 'positions':
                    $this->importPositions($output);
                    break;
                case 'teams':
                    $this->importTeams($output);
                    break;
                default:
                    throw new \InvalidArgumentException(
                        sprintf(
                            'No import available for type "%s"',
                            $type
                        )
                    );
                    break;
            }

            $output->writeln(
                array(
                    '',
                    '-----------------------------------------',
                    sprintf('Finished import of %s', $type),
                )
            );
        }

        $output->writeln([
            '',
            '=========================================',
            'Finished import',
            '',
        ]);

        return 0;
    }

    /**
     * @param OutputInterface $output
     */
    protected function importEmployees(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/employees'
        );

        $entityManager = $this->getEntityManager();
        $employeeRepository = $entityManager->getRepository(Employee::class);
        $employeeTypeRepository = $entityManager->getRepository(EmployeeType::class);

        foreach ($data['employees'] as $employeeData) {
            $new = false;

            $employee = $employeeRepository->findOneBy(
                array(
                    'firstName' => $employeeData['first_name'],
                    'lastName' => $employeeData['last_name'],
                )
            );

            $employeeData['types'] = $employeeTypeRepository->findBy(
                array(
                    'name' => $employeeData['types'],
                )
            );

            if ($employee === null) {
                $employee = Employee::fromArray($employeeData);
                $new = true;
            } else {
                $employee = $employeeRepository->hydrate($employee, $employeeData);
            }

            if (array_key_exists('picture', $employeeData) === true) {
                $picturePath = self::BASE_PATH_PICTURES . 'employees/';

                $employee->setPictureUrl(
                    $this->moveFile($employeeData['picture'], $picturePath, $employee->getFirstName() . $employee->getLastName())
                );
            }

            $entityManager->persist($employee);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        sprintf(
                            '%s %s',
                            $employee->getFirstName(),
                            $employee->getLastName())
                    ),
                )
            );
        }
    }

    /**
     * @param OutputInterface $output
     */
    protected function importEmployeeTypes(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/employee-types'
        );

        $entityManager = $this->getEntityManager();
        $typeRepository = $entityManager->getRepository(EmployeeType::class);

        foreach ($data['types'] as $typeData) {
            $new = false;

            $type = $typeRepository->findOneBy(
                array(
                    'name' => $typeData['name'],
                )
            );

            if ($type === null) {
                $type = EmployeeType::fromArray($typeData);
                $new = true;
            } else {
                $type = $typeRepository->hydrate($type, $typeData);
            }

            $entityManager->persist($type);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        $type->getName()
                    ),
                )
            );
        }
    }

    /**
     * @param OutputInterface $output
     */
    protected function importPlayers(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/players'
        );

        $entityManager = $this->getEntityManager();
        $playerRepository = $entityManager->getRepository(Player::class);
        $positionRepository = $entityManager->getRepository(PlayerPosition::class);

        foreach ($data['players'] as $playerData) {
            $new = false;

            $player = $playerRepository->findOneBy(
                array(
                    'name' => $playerData['name'],
                )
            );

            if (array_key_exists('position', $playerData)) {
                $playerData['position'] = $positionRepository->findOneBy(
                    array(
                        'name' => $playerData['position'],
                    )
                );
            }

            if (array_key_exists('birth_date', $playerData)) {
                $playerData['birth_date'] = DateTime::createFromFormat('Y-m-d', $playerData['birth_date']);
            }

            if ($player === null) {
                $player = Player::fromArray($playerData);
                $new = true;
            } else {
                $player = $playerRepository->hydrate($player, $playerData);
            }

            if (array_key_exists('picture', $playerData) === true) {
                $picturePath = self::BASE_PATH_PICTURES . 'players/';

                $player->setPictureUrl(
                    $this->moveFile($playerData['picture'], $picturePath, $player->getName())
                );
            }

            $entityManager->persist($player);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        $player->getName()
                    ),
                )
            );
        }
    }

    /**
     * @param OutputInterface $output
     */
    protected function importPositions(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/positions'
        );

        $entityManager = $this->getEntityManager();
        $positionRepository = $entityManager->getRepository(PlayerPosition::class);

        foreach ($data['positions'] as $positionData) {
            $new = false;

            $position = $positionRepository->findOneBy(
                array(
                    'name' => $positionData['name'],
                )
            );

            if ($position === null) {
                $position = PlayerPosition::fromArray($positionData);
                $new = true;
            } else {
                $position = $positionRepository->hydrate($position, $positionData);
            }

            $entityManager->persist($position);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        $position->getName()
                    ),
                )
            );
        }
    }

    /**
     * @param OutputInterface $output
     */
    protected function importTeams(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/teams'
        );

        $entityManager = $this->getEntityManager();
        $teamRepository = $entityManager->getRepository(Team::class);
        $employeeRepository = $entityManager->getRepository(Employee::class);
        $playerRepository = $entityManager->getRepository(Player::class);

        foreach ($data['teams'] as $teamData) {
            $new = false;

            $team = $teamRepository->findOneBy(
                array(
                    'name' => $teamData['name'],
                )
            );

            $employees = array();

            foreach ($teamData['employees'] as $employeeData) {
                $employee = $employeeRepository->findOneBy(
                    array(
                        'firstName' => $employeeData['first_name'],
                        'lastName' => $employeeData['last_name'],
                    )
                );

                if ($employee) {
                    $employees[] = $employee;
                }
            }

            $teamData['employees'] = $employees;

            if (array_key_exists('players', $teamData)) {
                $players = array();

                foreach ($teamData['players'] as $playerName) {
                    $player = $playerRepository->findOneBy(
                        array(
                            'name' => $playerName,
                        )
                    );

                    if ($player) {
                        $players[] = $player;
                    }
                }

                $teamData['players'] = $players;
            }

            if ($team === null) {
                $team = Team::fromArray($teamData);
                $new = true;
            } else {
                $team = $teamRepository->hydrate($team, $teamData);
            }

            if (array_key_exists('picture', $teamData) === true) {
                $picturePath = self::BASE_PATH_PICTURES . 'teams/';

                $team->setPictureUrl(
                    $this->moveFile($teamData['picture'], $picturePath, $team->getName())
                );
            }

            $entityManager->persist($team);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        $team->getName()
                    ),
                )
            );
        }
    }

    /**
     * @param string $url
     * @param string $destination
     * @return string
     */
    protected function moveFile($url, $destination, $fileName)
    {
        $content = file_get_contents($url);

        $fileName = preg_replace(
            array(
                '/[^a-zA-Z0-9 \-]+/',
                '/ /',
            ),
            array(
                '-',
                '',
            ),
            strtolower($fileName)
        ) . '.jpg';

        $this->getS3Client()->putObject(
            array(
                'Bucket' => self::BUCKET_NAME,
                'Key'    => $destination . $fileName,
                'Body'   => $content,
                'ACL'    => 'public-read',
            )
        );

        return $destination . $fileName;
    }

    /**
     * @param string $url
     * @return array
     */
    protected function import($url)
    {
        $import = new Import($url);
        return $import->import();
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return S3Client
     */
    public function getS3Client()
    {
        return $this->s3Client;
    }

    /**
     * @param S3Client $s3Client
     */
    public function setS3Client($s3Client)
    {
        $this->s3Client = $s3Client;
    }
}
