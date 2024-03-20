<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profile_employers', function (Blueprint $table) {
            $table->string('funding')->nullable();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->boolean('has_gp_agreement')->default(false);
            $table->string('gp_name')->nullable();
            $table->string('gp_email')->nullable();
            $table->string('gp_phone')->nullable();
        });
    }
};
