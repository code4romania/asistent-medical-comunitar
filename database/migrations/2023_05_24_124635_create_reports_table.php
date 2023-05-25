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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->nullable();
            $table->string('type');
            $table->date('date_from')->nullable();
            $table->date('date_until')->nullable();
            $table->json('indicators')->nullable();
            $table->json('segments')->nullable();
            $table->json('data')->nullable();
        });
    }
};
