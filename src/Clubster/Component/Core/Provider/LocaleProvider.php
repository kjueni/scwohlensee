<?php

declare(strict_types=1);

namespace Clubster\Component\Locale\Provider;

use Clubster\Component\Core\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class LocaleProvider implements LocaleProviderInterface
{
    /** @var RepositoryInterface */
    private $localeRepository;

    /** @var string */
    private $defaultLocaleCode;

    public function __construct(RepositoryInterface $localeRepository, string $defaultLocaleCode)
    {
        $this->localeRepository = $localeRepository;
        $this->defaultLocaleCode = $defaultLocaleCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableLocalesCodes(): array
    {
        $locales = $this->localeRepository->findAll();

        return array_map(
            function (LocaleInterface $locale) {
                return $locale->getCode();
            },
            $locales
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultLocaleCode(): string
    {
        return $this->defaultLocaleCode;
    }
}
