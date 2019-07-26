<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFixturesCommand extends ContainerAwareCommand
{
    /**
     * @var ObjectManager
     */
    protected $doctrine;

    /**
     * @param ObjectManager $doctrine
     * @param string $name
     */
    public function __construct(ObjectManager $doctrine, string $name = null)
    {
        parent::__construct($name);

        $this->doctrine = $doctrine;
    }

    protected function configure()
    {
        $this
            ->setName('clubster:fixtures:load')
            ->setAliases(['clubster:fixtures:load'])
            ->addOption('connection', 'c', InputOption::VALUE_OPTIONAL, 'The doctrine connection', 'default')
            ->addArgument('fixtures', InputArgument::IS_ARRAY,
                'Defines which fixtures should be loaded (core, test)',
                ['core', 'test'])
            ->setDescription('Loads fixtures');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $availableFixtures = $container->getParameter('fixtures');
        $inputFixtures = $input->getArgument('fixtures');
        $finalFixtures = [];

        foreach ($availableFixtures as $availableFixture) {
            foreach ($inputFixtures as $inputFixture) {
                if (strpos($availableFixture, $inputFixture) !== false) {
                    $finalFixtures[] = $availableFixture;
                }
            }
        }

        $environment = $input->getOption('env');
        $connection = $input->getOption('connection');

        //Ensure em is cleared - need for some tests
        $this->doctrine->clear();

        $application = static::getApplication();
        $application->setAutoExit(false);

        if ($environment === 'dev' || $environment === 'test') {
            $application->run(new ArrayInput([
                'command' => 'doctrine:database:drop',
                '--force' => true,
                '--env' => $environment,
                '--connection' => $connection,
                '-vvv' => true,
            ]), $output);

            $application->run(new ArrayInput([
                'command' => 'doctrine:database:create',
                '--env' => $environment,
                '--connection' => $connection,
                '-vvv' => true,
            ]), $output);

            $output->writeln('Updating schema');
            $output = new NullOutput();
            $application->run(new ArrayInput([
                'command' => 'doctrine:schema:update',
                '--force' => true,
                '--dump-sql' => true,
                '--env' => $environment,
                '--em' => $connection,
                '-vvv' => true,
            ]), $output);
        }

        $loader = new NativeLoader();
        $objectSet = $loader->loadFiles($finalFixtures);

        foreach ($objectSet->getObjects() as $object) {
            $this->doctrine->persist($object);
        }

        $this->doctrine->flush();

        // Only re-add migrations if in dev
        if ($environment === 'dev') {
            $commandInput = new ArrayInput([
                'command' => 'doctrine:migrations:version',
                '--no-interaction' => true,
                '--add' => true,
                '--all' => true,
                '-vvv' => true,
                '--connection' => $connection,
            ]);

            $application->run($commandInput, $output);
        }
    }
}
