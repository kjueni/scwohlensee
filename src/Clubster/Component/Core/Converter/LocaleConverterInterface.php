<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Converter;

interface LocaleConverterInterface
{
    /**
     * @throws \InvalidArgumentException
     */
    public function convertNameToCode(string $name, ?string $locale = null): string;

    /**
     * @throws \InvalidArgumentException
     */
    public function convertCodeToName(string $code, ?string $locale = null): string;
}
