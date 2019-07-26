<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Fixture;

interface FixtureAwareInterface
{
    /**
     * @return string
     */
    public static function getFixturesPath(): string;
}
