<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Provider;

interface LocaleProviderInterface
{
    /**
     * @return string[]
     */
    public function getAvailableLocalesCodes(): array;

    public function getDefaultLocaleCode(): string;
}
