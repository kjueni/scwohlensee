<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle;

use Clubster\Bundle\CoreBundle\CompilerPass\CollectFixturesPass;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\ResourceBundleInterface;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ClubsterCoreBundle extends AbstractResourceBundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new CollectFixturesPass());
    }

    /**
     * Configure format of mapping files.
     *
     * @var string
     */
    protected $mappingFormat = ResourceBundleInterface::MAPPING_YAML;

    /**
     * @return array
     */
    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    /**
     * @return string
     */
    protected function getModelNamespace(): string
    {
        return 'Clubster\Component\Core\Model';
    }
}