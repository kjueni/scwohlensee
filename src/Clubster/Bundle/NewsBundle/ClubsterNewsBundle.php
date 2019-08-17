<?php

declare(strict_types=1);

namespace Clubster\Bundle\NewsBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\ResourceBundleInterface;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

final class ClubsterNewsBundle extends AbstractResourceBundle
{
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
        return 'Clubster\Component\News\Model';
    }
}