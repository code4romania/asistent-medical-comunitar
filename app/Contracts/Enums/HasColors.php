<?php

declare(strict_types=1);

namespace App\Contracts\Enums;

interface HasColors
{
    public static function colorMap(): array;

    public static function colors(): array;

    public function color(): ?string;
}
