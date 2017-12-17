<?php

namespace App\Entity;

interface EntityInterface
{
    /**
     * @param array $params
     * @return EntityInterface
     */
    public static function fromArray(array $params);
}
