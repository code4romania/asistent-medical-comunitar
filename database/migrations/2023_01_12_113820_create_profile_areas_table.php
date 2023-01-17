<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\County;
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
        Schema::create('profile_areas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(County::class)->constrained();
            $table->foreignIdFor(City::class)->constrained();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
        });
    }
};
