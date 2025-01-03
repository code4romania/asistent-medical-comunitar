<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vulnerabilities', function (Blueprint $table) {
            $table->boolean('is_valid')
                ->virtualAs(<<<'SQL'
                    CASE
                        WHEN id LIKE '%\\_9_' THEN 0
                        ELSE 1
                    END
                SQL)
                ->change();
        });
    }
};
