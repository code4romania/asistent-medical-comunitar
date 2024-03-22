<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->after('cnp', function (Blueprint $table) {
                $table->boolean('does_not_have_cnp')->default(false);
                $table->boolean('does_not_provide_cnp')->default(false);
            });
        });
    }
};
