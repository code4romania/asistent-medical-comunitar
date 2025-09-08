<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Throwable;
use App\Enums\User\Role;
use App\Imports\AdminsImport;
use App\Imports\CoordinatorsImport;
use App\Imports\NursesImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run user importer.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $role = $this->choice('What role should we assign to the imported users?', Role::options());

        $files = collect(Storage::disk('local')->files('import'))
            ->filter(fn (string $file) => \in_array(pathinfo(Str::lower($file), \PATHINFO_EXTENSION), ['csv', 'xlsx']))
            ->values()
            ->all();

        $file = $this->choice('What file should we import?', $files);

        $importer = match (Role::tryFrom($role)) {
            Role::ADMIN => AdminsImport::class,
            Role::COORDINATOR => CoordinatorsImport::class,
            Role::NURSE => NursesImport::class,
        };

        try {
            (new $importer)->import($file, 'local');

            Storage::disk('local')->delete($file);
        } catch (Throwable $th) {
            $this->error($th->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
