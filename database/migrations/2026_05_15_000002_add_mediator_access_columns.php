<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->unsignedBigInteger('nurse_id')->nullable()->change();

            $table->foreignIdFor(User::class, 'mediator_id')
                ->nullable()
                ->after('nurse_id')
                ->constrained('users')
                ->nullOnDelete();
        });

        Schema::table('community_activities', function (Blueprint $table) {
            $table->foreignIdFor(User::class, 'mediator_id')
                ->nullable()
                ->after('nurse_id')
                ->constrained('users')
                ->nullOnDelete();
        });

        Schema::table('interventions', function (Blueprint $table) {
            $table->boolean('mediator_has_access')
                ->default(false)
                ->after('integrated');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreignIdFor(User::class, 'user_id')
                ->nullable()
                ->after('beneficiary_id')
                ->constrained('users')
                ->nullOnDelete();
        });
    }
};
