<?php

declare(strict_types=1);

use App\Models\Media;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Media::query()
            ->where('disk', 'private')
            ->orWhere('conversions_disk', 'private')
            ->update([
                'disk' => 'local',
                'conversions_disk' => 'local',
            ]);
    }
};
