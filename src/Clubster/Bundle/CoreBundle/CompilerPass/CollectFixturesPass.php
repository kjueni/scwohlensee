<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\CompilerPass;

use Clubster\Component\Core\Fixture\FixtureAwareInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;

class CollectFixturesPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function process(ContainerBuilder $container)
    {
        $files = [];

        foreach ($container->getExtensions() as $extension) {
            if ($extension instanceof FixtureAwareInterface && is_dir($extension->getFixturesPath())) {
                $finder = new Finder();
                $finder->files()->in($extension->getFixturesPath());

                if ($finder->hasResults()) {
                    foreach ($finder as $file) {
                        if ($file->getExtension() !== 'yml') {
                            throw new \Exception(sprintf(
                                'Invalid file extension: "%s" only yml files allowed.',
                                $file->getExtension()
                            ));
                        }

                        $files[] = $file->getRealPath();
                    }
                }
            }
        }

        $fixtures = $container->getParameter('fixtures');

        if (!$fixtures) {
            $fixtures = [];
        }

        $fixtures = array_merge($fixtures, $files);

        $container->setParameter('fixtures', $fixtures);
    }
}
