<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\DependencyInjection;

use Clubster\Component\Core\Fixture\FixtureAwareInterface;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class ClubsterCoreExtension extends AbstractResourceExtension implements FixtureAwareInterface
{
    /**
     * @param array $config
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);

        $this->registerResources(
            'clubster',
            $config['driver'],
            $this->resolveResources($config['resources'], $container),
            $container
        );

        $container->setParameter('clubster_admin.firewall_context_name', $config['firewall_context_name']);
        $container->setParameter('clubster_core.tmp_dir', $config['tmp_dir']);
        $container->setParameter('clubster_core.stable_version', $config['stable_version']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

    }

    /**
     * @param array $resources
     * @param ContainerBuilder $container
     * @return array
     */
    private function resolveResources(array $resources, ContainerBuilder $container): array
    {
        $resolvedResources = [];
        foreach ($resources as $variableName => $variableConfig) {
            foreach ($variableConfig as $resourceName => $resourceConfig) {
                if (is_array($resourceConfig)) {
                    $resolvedResources[$variableName . '_' . $resourceName] = $resourceConfig;
                }
            }
        }

        return $resolvedResources;
    }

    /**
     * @return string
     */
    public static function getFixturesPath(): string
    {
        return __DIR__ . '/../Resources/config/fixtures';
    }
}
