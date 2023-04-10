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
        $admin = User::factory(['email' => 'admin@example.com'])
            ->admin()
            ->create();

        // Create a community nurse
        $nurse = User::factory(['email' => 'nurse@example.com'])
            ->nurse()
            ->withProfile()
            ->create();

        Beneficiary::factory()
            ->count(10)
            ->recycle($nurse)
            ->create();

        Beneficiary::factory()
            ->count(10)
            ->withAddress()
            ->recycle($nurse)
            ->create();

        Beneficiary::factory()
            ->withID()
            ->count(10)
            ->recycle($nurse)
            ->create();

        Beneficiary::factory()
            ->withNotes()
            ->count(10)
            ->recycle($nurse)
            ->create();
    }
}
