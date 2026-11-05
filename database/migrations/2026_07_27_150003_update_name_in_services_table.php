<?php

declare(strict_types=1);

use App\Models\Service\Service;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Service::query()
            ->where('code', 'STR_11')
            ->update([
                'name' => 'Mobilizare vaccin',
            ]);
    }
};
