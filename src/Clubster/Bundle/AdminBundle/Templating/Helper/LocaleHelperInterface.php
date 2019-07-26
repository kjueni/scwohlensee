<?php

declare(strict_types=1);

namespace Clubster\Bundle\AdminBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\HelperInterface;

interface LocaleHelperInterface extends HelperInterface
{
    /**
     * @param string $code The code to be converted to a name
     * @param string|null $localeCode The locale that the returned name should be in
     */
    public function convertCodeToName(string $code, ?string $localeCode = null): ?string;
}
