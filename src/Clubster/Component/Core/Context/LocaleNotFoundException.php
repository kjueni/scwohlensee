<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Context;

final class LocaleNotFoundException extends \RuntimeException
{
    /**
     * {@inheritdoc}
     */
    public function __construct(?string $message = null, \Exception $previousException = null)
    {
        parent::__construct($message ?: 'Locale could not be found!', 0, $previousException);
    }

    public static function notFound(string $localeCode): self
    {
        return new self(sprintf('Locale "%s" cannot be found!', $localeCode));
    }

    public static function notAvailable(string $localeCode, array $availableLocalesCodes): self
    {
        return new self(sprintf(
            'Locale "%s" is not available! The available ones are: "%s".',
            $localeCode,
            implode('", "', $availableLocalesCodes)
        ));
    }
}
