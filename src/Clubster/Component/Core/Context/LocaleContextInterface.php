<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Context;

interface LocaleContextInterface
{
    /**
     * @throws LocaleNotFoundException
     */
    public function getLocaleCode(): string;
}
