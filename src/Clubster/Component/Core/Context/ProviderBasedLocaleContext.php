<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Context;

use Clubster\Component\Locale\Provider\LocaleProviderInterface;

final class ProviderBasedLocaleContext implements LocaleContextInterface
{
    /** @var LocaleProviderInterface */
    private $localeProvider;

    public function __construct(LocaleProviderInterface $localeProvider)
    {
        $this->localeProvider = $localeProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocaleCode(): string
    {
        $availableLocalesCodes = $this->localeProvider->getAvailableLocalesCodes();
        $localeCode = $this->localeProvider->getDefaultLocaleCode();

        if (!in_array($localeCode, $availableLocalesCodes, true)) {
            throw LocaleNotFoundException::notAvailable($localeCode, $availableLocalesCodes);
        }

        return $localeCode;
    }
}
