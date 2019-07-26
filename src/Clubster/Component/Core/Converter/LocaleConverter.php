<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Converter;

use Symfony\Component\Intl\Intl;
use Webmozart\Assert\Assert;

final class LocaleConverter implements LocaleConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function convertNameToCode(string $name, ?string $locale = null): string
    {
        $names = Intl::getLocaleBundle()->getLocaleNames($locale ?? 'en');
        $code = array_search($name, $names, true);

        Assert::string($code, sprintf('Cannot find code for "%s" locale name', $name));

        return $code;
    }

    /**
     * {@inheritdoc}
     */
    public function convertCodeToName(string $code, ?string $locale = null): string
    {
        $name = Intl::getLocaleBundle()->getLocaleName($code, $locale ?? 'en');

        Assert::string($name, sprintf('Cannot find name for "%s" locale code', $code));

        return $name;
    }
}
