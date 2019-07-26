<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Context;

final class ImmutableLocaleContext implements LocaleContextInterface
{
    /** @var string */
    private $localeCode;

    public function __construct(string $localeCode)
    {
        $this->localeCode = $localeCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocaleCode(): string
    {
        return $this->localeCode;
    }
}
