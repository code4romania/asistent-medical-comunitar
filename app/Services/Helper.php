<?php

namespace App\Services;

class Helper
{
    public static function generateYearsOptions(): array
    {
        $years = [];
        for ($i = 1950; $i < now()->year; $i++) {
            $years[$i] = $i;
        }

        return array_reverse($years);
    }
}
