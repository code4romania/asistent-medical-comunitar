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

        // Create a coordinator
        $coordinator = User::factory([
            'email' => 'coord@example.com',
            'username' => 'coord',
        ])
            ->coordinator()
            ->create();

        // Create a community nurse
        $nurse = User::factory(['email' => 'nurse@example.com'])
            ->nurse()
            ->withProfile()
            ->create();

        $this->generateBeneficiaries($nurse);

        User::factory()
            ->count(10)
            ->coordinator()
            ->create();

        User::factory()
            ->count(10)
            ->coordinator()
            ->deactivated()
            ->create();

        User::factory()
            ->count(5)
            ->nurse()
            ->invited()
            ->create();

        User::factory()
            ->count(5)
            ->nurse()
            ->deactivated()
            ->create();

        User::factory()
            ->count(5)
            ->nurse()
            ->withProfile()
            ->create()
            ->each(fn (User $nurse) => $this->generateBeneficiaries($nurse));
    }

    protected function generateBeneficiaries(User $nurse, int $count = 10): void
    {
        Beneficiary::factory()
            ->count($count)
            ->recycle($nurse)
            ->create();

        Beneficiary::factory()
            ->count($count)
            ->withAddress()
            ->withCNP()
            ->recycle($nurse)
            ->create();

        Beneficiary::factory()
            ->count($count)
            ->withID()
            ->withCNP()
            ->recycle($nurse)
            ->create();

        Beneficiary::factory()
            ->count($count)
            ->withNotes()
            ->recycle($nurse)
            ->create();
    }
}
