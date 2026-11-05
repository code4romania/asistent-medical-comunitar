<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['nurse_id']);
            $table->renameColumn('nurse_id', 'user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });

        Schema::table('vacations', function (Blueprint $table) {
            $table->dropForeign(['nurse_id']);
            $table->renameColumn('nurse_id', 'user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }
};
