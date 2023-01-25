<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin
        $user = User::factory(['email' => 'admin@example.com'])
            ->withProfile()
            ->create();

        Beneficiary::factory()
            ->count(10)
            ->recycle($user)
            ->create();

        Beneficiary::factory()
            ->count(10)
            ->withAddress()
            ->recycle($user)
            ->create();

        Beneficiary::factory()
            ->withID()
            ->count(10)
            ->recycle($user)
            ->create();

        Beneficiary::factory()
            ->withNotes()
            ->count(10)
            ->recycle($user)
            ->create();
    }
}
