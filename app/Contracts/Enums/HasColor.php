<?php

declare(strict_types=1);

namespace App\Contracts\Enums;

interface HasColor
{
    public static function colors(): array;

    public static function flipColors(): array;

    public function color(): ?string;
}
