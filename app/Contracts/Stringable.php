<?php

declare(strict_types=1);

namespace App\Contracts;

interface Stringable
{
    /**
     * Get content as a string.
     *
     * @return string
     */
    public function toString(): string;
}
