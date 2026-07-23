<?php

declare(strict_types=1);

use Illuminate\Queue\Console\FlushFailedCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(FlushFailedCommand::class)
    ->onOneServer()
    ->daily();

Schedule::command('horizon:snapshot')
    ->everyFiveMinutes();
