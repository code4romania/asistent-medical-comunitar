<?php

declare(strict_types=1);

use App\Models\Catagraphy;
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
        Schema::create('diseases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->string('diagnostic')->nullable();
            $table->string('diagnostic_code')->nullable();
            $table->year('start_year')->nullable();
            $table->string('notes')->nullable();

            $table->foreignIdFor(Catagraphy::class)->constrained()->cascadeOnDelete();
        });
    }
};
