<?php

declare(strict_types=1);

namespace Clubster\Bundle\AdminBundle\Twig;

use Clubster\Bundle\AdminBundle\Templating\Helper\LocaleHelperInterface;

final class LocaleExtension extends \Twig_Extension
{
    /** @var LocaleHelperInterface */
    private $localeHelper;

    public function __construct(LocaleHelperInterface $localeHelper)
    {
        $this->localeHelper = $localeHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(): array
    {
        return [
            new \Twig_Filter('sylius_locale_name', [$this->localeHelper, 'convertCodeToName']),
        ];
    }
}
