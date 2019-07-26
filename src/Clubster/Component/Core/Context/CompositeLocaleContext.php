<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Context;

use Zend\Stdlib\PriorityQueue;

final class CompositeLocaleContext implements LocaleContextInterface
{
    /** @var PriorityQueue|LocaleContextInterface[] */
    private $localeContexts;

    public function __construct()
    {
        $this->localeContexts = new PriorityQueue();
    }

    public function addContext(LocaleContextInterface $localeContext, int $priority = 0): void
    {
        $this->localeContexts->insert($localeContext, $priority);
    }

    /**
     * {@inheritdoc}
     */
    public function getLocaleCode(): string
    {
        $lastException = null;

        foreach ($this->localeContexts as $localeContext) {
            try {
                return $localeContext->getLocaleCode();
            } catch (LocaleNotFoundException $exception) {
                $lastException = $exception;

                continue;
            }
        }

        throw new LocaleNotFoundException(null, $lastException);
    }
}
