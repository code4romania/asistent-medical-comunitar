<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\CommunityActivity;
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
        // Create community activities
        CommunityActivity::factory()
            ->count(25)
            ->create();

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
            ->withCNP()
            ->recycle($nurse)
            ->create();

        Beneficiary::factory()
            ->count(10)
            ->withID()
            ->withCNP()
            ->recycle($nurse)
            ->create();

        Beneficiary::factory()
            ->count(10)
            ->withNotes()
            ->recycle($nurse)
            ->create();
    }
}
