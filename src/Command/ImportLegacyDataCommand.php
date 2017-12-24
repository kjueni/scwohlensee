<?php
namespace App\Command;

use DateTime;

use Aws\S3\S3Client;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use App\Entity;
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
            ->addOption(
                'images',
                'i',
                InputOption::VALUE_OPTIONAL,
                'Defines if images should be imported or not',
                0
            )
            ->addArgument(
                'types',
                InputArgument::IS_ARRAY,
                'One or more types to import',
                array(
                    'employee-types',
                    'employees',
                    'game-types',
                    'navigation-entries',
                    'news-types',
                    'news',
                    'pages',
                    'pitches',
                    'positions',
                    'players',
                    'teams',
                    'training-sessions',
                    'ad-types',
                    'ads',
                    'boxes',
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
                case 'ad-types':
                    $this->importAdTypes($output);
                    break;
                case 'ads':
                    $this->importAds($output, $input->getOption('images') === 1);
                    break;
                case 'boxes':
                    $this->importBoxes($output);
                    break;
                case 'employee-types':
                    $this->importEmployeeTypes($output);
                    break;
                case 'employees':
                    $this->importEmployees($output, $input->getOption('images') === 1);
                    break;
                case 'game-types':
                    $this->importGameTypes($output);
                    break;
                case 'navigation-entries':
                    $this->importNavigationEntries($output);
                    break;
                case 'news-types':
                    $this->importNewsTypes($output);
                    break;
                case 'news':
                    $this->importNews($output, $input->getOption('images') === 1);
                    break;
                case 'pages':
                    $this->importPages($output);
                    break;
                case 'pitches':
                    $this->importPitches($output);
                    break;
                case 'players':
                    $this->importPlayers($output, $input->getOption('images') === 1);
                    break;
                case 'positions':
                    $this->importPositions($output);
                    break;
                case 'teams':
                    $this->importTeams($output, $input->getOption('images') === 1);
                    break;
                case 'training-sessions':
                    $this->importTrainingSessions($output);
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
     * @param boolean $importImages
     */
    protected function importAds(OutputInterface $output, $importImages = false)
    {
        $data = $this->import(
            self::BASE_URL . '/ads'
        );

        $entityManager = $this->getEntityManager();
        $adRepository = $entityManager->getRepository(Entity\Ad::class);
        $adTypeRepository = $entityManager->getRepository(Entity\AdType::class);
        $teamRepository = $entityManager->getRepository(Entity\Team::class);

        foreach ($data['ads'] as $adData) {
            $new = false;

            /** @var Entity\Ad $ad */
            $ad = $adRepository->findOneBy(
                array(
                    'pictureUrl' => $adData['picture'],
                    'description' => $adData['description'],
                    'url' => array_key_exists('url', $adData) === true ? $adData['url'] : null,
                )
            );

            $adData['types'] = $adTypeRepository->findBy(
                array(
                    'name' => $adData['types'],
                )
            );

            if (array_key_exists('teams', $adData) === true) {
                $adData['teams'] = $teamRepository->findBy(
                    array(
                        'name' => $adData['teams'],
                    )
                );
            }

            if ($ad === null) {
                $ad = Entity\Ad::fromArray($adData);
                $new = true;
            } else {
                $ad = $adRepository->hydrate($ad, $adData);
            }

            if (array_key_exists('picture', $adData) === true && $importImages === true) {
                $picturePath = self::BASE_PATH_PICTURES . 'ads/';

                $ad->setPictureUrl(
                    $this->moveFile($adData['picture'], $picturePath, $ad->getDescription())
                );
            }

            $entityManager->persist($ad);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        sprintf(
                            '%s %s',
                            $ad->getUrl(),
                            $ad->getDescription())
                    ),
                )
            );
        }
    }

    /**
     * @param OutputInterface $output
     */
    protected function importAdTypes(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/ad-types'
        );

        $entityManager = $this->getEntityManager();
        $typeRepository = $entityManager->getRepository(Entity\AdType::class);

        foreach ($data['types'] as $typeData) {
            $new = false;

            $type = $typeRepository->findOneBy(
                array(
                    'name' => $typeData['name'],
                )
            );

            $typeData['height'] = (int) (array_key_exists('height', $typeData) ? $typeData['height'] : 0);

            if ($type === null) {
                $type = Entity\AdType::fromArray($typeData);
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
    protected function importBoxes(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/boxes'
        );

        $entityManager = $this->getEntityManager();
        $boxRepository = $entityManager->getRepository(Entity\Box::class);
        $navigationEntryRepository = $entityManager->getRepository(Entity\NavigationEntry::class);

        foreach ($data['boxes'] as $boxData) {
            $new = false;

            $box = $boxRepository->findOneBy(
                array(
                    'title' => $boxData['title'],
                )
            );

            $adData['navigation_entries'] = $navigationEntryRepository->findBy(
                array(
                    'title' => $boxData['navigation_entries'],
                )
            );

            if ($box === null) {
                $box = Entity\Box::fromArray($boxData);
                $new = true;
            } else {
                $box = $boxRepository->hydrate($box, $boxData);
            }

            $entityManager->persist($box);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        $box->getTitle()
                    ),
                )
            );
        }
    }

    /**
     * @param OutputInterface $output
     * @param boolean $importImages
     */
    protected function importEmployees(OutputInterface $output, $importImages = false)
    {
        $data = $this->import(
            self::BASE_URL . '/employees'
        );

        $entityManager = $this->getEntityManager();
        $employeeRepository = $entityManager->getRepository(Entity\Employee::class);
        $employeeTypeRepository = $entityManager->getRepository(Entity\EmployeeType::class);

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
                $employee = Entity\Employee::fromArray($employeeData);
                $new = true;
            } else {
                $employee = $employeeRepository->hydrate($employee, $employeeData);
            }

            if (array_key_exists('picture', $employeeData) === true && $importImages === true) {
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
        $typeRepository = $entityManager->getRepository(Entity\EmployeeType::class);

        foreach ($data['types'] as $typeData) {
            $new = false;

            $type = $typeRepository->findOneBy(
                array(
                    'name' => $typeData['name'],
                )
            );

            if ($type === null) {
                $type = Entity\EmployeeType::fromArray($typeData);
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
    protected function importGameTypes(OutputInterface $output)
    {
        $data = array(
            array(
                'name' => 'Cup',
            ),
            array(
                'name' => 'Meisterschaft',
            ),
            array(
                'name' => 'Trainingsspiele',
            ),
            array(
                'name' => 'Turnier',
            )
        );

        $entityManager = $this->getEntityManager();
        $typeRepository = $entityManager->getRepository(Entity\GameType::class);

        foreach ($data as $typeData) {
            $new = false;

            $type = $typeRepository->findOneBy(
                array(
                    'name' => $typeData['name'],
                )
            );

            if ($type === null) {
                $type = Entity\GameType::fromArray($typeData);
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
    protected function importNavigationEntries(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/navigations'
        );

        $entityManager = $this->getEntityManager();
        $navigationEntryRepository = $entityManager->getRepository(Entity\NavigationEntry::class);

        /**
         * @param array $data
         * @param Entity\NavigationEntry|null $parent
         */
        $createItem = function ($data, Entity\NavigationEntry $parent = null) use (&$createItem, $entityManager, $navigationEntryRepository, $output) {
            $new = false;

            $entry = $navigationEntryRepository->findOneBy(
                array(
                    'title' => $data['title'],
                )
            );

            if ($entry === null) {
                $entry = Entity\NavigationEntry::fromArray($data);
                $new = true;
            } else {
                $entry = $navigationEntryRepository->hydrate($entry, $data);
            }

            if ($parent !== null) {
                $entry->setParent($parent);
            }

            $entityManager->persist($entry);
            $entityManager->flush();

            if (array_key_exists('children', $data)) {
                foreach ($data['children'] as $childrenData) {
                    $createItem($childrenData, $entry);
                }
            }

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        $entry->getTitle()
                    ),
                )
            );
        };

        foreach ($data['navigations'] as $navigationData) {
            $createItem($navigationData, null);
        }
    }

    /**
     * @param OutputInterface $output
     * @param boolean $importImages
     */
    protected function importNews(OutputInterface $output, $importImages = false)
    {
        $data = $this->import(
            self::BASE_URL . '/news'
        );

        $entityManager = $this->getEntityManager();
        $newsRepository = $entityManager->getRepository(Entity\News::class);
        $newsTypeRepository = $entityManager->getRepository(Entity\NewsType::class);

        foreach ($data['news'] as $newsData) {
            $new = false;

            $news = $newsRepository->findOneBy(
                array(
                    'title' => $newsData['title'],
                )
            );

            if (array_key_exists('types', $newsData) !== true) {
                // If the news has no type let it go
                continue;
            }

            $newsData['types'] = $newsTypeRepository->findBy(
                array(
                    'name' => $newsData['types'],
                )
            );

            if ($news === null) {
                $news = Entity\News::fromArray($newsData);
                $new = true;
            } else {
                $news = $newsRepository->hydrate($news, $newsData);
            }

            if (array_key_exists('picture', $newsData) === true && $importImages === true) {
                $picturePath = self::BASE_PATH_PICTURES . 'news/';

                $news->setPictureUrl(
                    $this->moveFile($newsData['picture'], $picturePath, $news->getTitle())
                );
            }

            $entityManager->persist($news);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        $news->getTitle()
                    ),
                )
            );
        }
    }

    /**
     * @param OutputInterface $output
     */
    protected function importNewsTypes(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/news-types'
        );

        $entityManager = $this->getEntityManager();
        $typeRepository = $entityManager->getRepository(Entity\NewsType::class);

        foreach ($data['types'] as $typeData) {
            $new = false;

            $type = $typeRepository->findOneBy(
                array(
                    'name' => $typeData['name'],
                )
            );

            if ($type === null) {
                $type = Entity\NewsType::fromArray($typeData);
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
    protected function importPages(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/pages'
        );

        $entityManager = $this->getEntityManager();
        $pageRepository = $entityManager->getRepository(Entity\Page::class);

        foreach ($data['pages'] as $pageData) {
            $new = false;

            $page = $pageRepository->findOneBy(
                array(
                    'title' => $pageData['title'],
                )
            );

            if ($page === null) {
                $page = Entity\Page::fromArray($pageData);
                $new = true;
            } else {
                $page = $pageRepository->hydrate($page, $pageData);
            }

            $entityManager->persist($page);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        $page->getTitle()
                    ),
                )
            );
        }
    }

    /**
     * @param OutputInterface $output
     */
    protected function importPitches(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/pitches'
        );

        $entityManager = $this->getEntityManager();
        $pitchRepository = $entityManager->getRepository(Entity\Pitch::class);

        foreach ($data['pitches'] as $pitchData) {
            $new = false;

            $pitch = $pitchRepository->findOneBy(
                array(
                    'name' => $pitchData['name'],
                )
            );

            if ($pitch === null) {
                $pitch = Entity\Pitch::fromArray($pitchData);
                $new = true;
            } else {
                $pitch = $pitchRepository->hydrate($pitch, $pitchData);
            }

            $entityManager->persist($pitch);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        $pitch->getName()
                    ),
                )
            );
        }
    }

    /**
     * @param OutputInterface $output
     * @param boolean $importImages
     */
    protected function importPlayers(OutputInterface $output, $importImages = false)
    {
        $data = $this->import(
            self::BASE_URL . '/players'
        );

        $entityManager = $this->getEntityManager();
        $playerRepository = $entityManager->getRepository(Entity\Player::class);
        $positionRepository = $entityManager->getRepository(Entity\PlayerPosition::class);

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
                $player = Entity\Player::fromArray($playerData);
                $new = true;
            } else {
                $player = $playerRepository->hydrate($player, $playerData);
            }

            if (array_key_exists('picture', $playerData) === true && $importImages === true) {
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
        $positionRepository = $entityManager->getRepository(Entity\PlayerPosition::class);

        foreach ($data['positions'] as $positionData) {
            $new = false;

            $position = $positionRepository->findOneBy(
                array(
                    'name' => $positionData['name'],
                )
            );

            if ($position === null) {
                $position = Entity\PlayerPosition::fromArray($positionData);
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
     * @param boolean $importImages
     */
    protected function importTeams(OutputInterface $output, $importImages = false)
    {
        $data = $this->import(
            self::BASE_URL . '/teams'
        );

        $entityManager = $this->getEntityManager();
        $teamRepository = $entityManager->getRepository(Entity\Team::class);
        $employeeRepository = $entityManager->getRepository(Entity\Employee::class);
        $playerRepository = $entityManager->getRepository(Entity\Player::class);

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
                $team = Entity\Team::fromArray($teamData);
                $new = true;
            } else {
                $team = $teamRepository->hydrate($team, $teamData);
            }

            if (array_key_exists('picture', $teamData) === true && $importImages === true) {
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
     * @param OutputInterface $output
     */
    protected function importTrainingSessions(OutputInterface $output)
    {
        $data = $this->import(
            self::BASE_URL . '/training-sessions'
        );

        $entityManager = $this->getEntityManager();
        $sessionRepository = $entityManager->getRepository(Entity\TrainingSession::class);
        $teamRepository = $entityManager->getRepository(Entity\Team::class);
        $pitchRepository = $entityManager->getRepository(Entity\Pitch::class);

        foreach ($data['sessions'] as $sessionData) {
            $new = false;

            $session = $sessionRepository->findOneBy(
                array(
                    'weekday' => $sessionData['weekday'],
                    'startsOn' => $sessionData['starts_on'],
                )
            );

            if (array_key_exists('pitch', $sessionData) === true) {
                $pitch = $pitchRepository->findOneBy(
                    array(
                        'name' => $sessionData['pitch'],
                    )
                );

                $sessionData['pitch'] = $pitch;
            }

            if (array_key_exists('team', $sessionData) === true) {
                $team = $teamRepository->findOneBy(
                    array(
                        'name' => $sessionData['team'],
                    )
                );

                $sessionData['team'] = $team;
            }

            if ($session === null) {
                $session = Entity\TrainingSession::fromArray($sessionData);
                $new = true;
            } else {
                $session = $sessionRepository->hydrate($session, $sessionData);
            }

            $entityManager->persist($session);
            $entityManager->flush();

            $output->writeln(
                array(
                    sprintf(
                        '%s - %s',
                        $new ? 'created' : 'updated',
                        $session->getWeekday()
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
