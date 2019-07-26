<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Model;

use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface LocaleInterface extends ResourceInterface, CodeAwareInterface, TimestampableInterface
{
    /**
     * @param null|string $locale
     * @return null|string
     */
    public function getName(?string $locale = null): ?string;
}
