<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_activity_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(City::class)->constrained();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();

            $table->unique(['city_id', 'user_id']);
        });
    }
};
