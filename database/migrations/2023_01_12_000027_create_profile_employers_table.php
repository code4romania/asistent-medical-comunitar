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
        Schema::create('profile_employers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('project')->nullable();
            $table->foreignIdFor(County::class)->nullable()->constrained();
            $table->foreignIdFor(City::class)->nullable()->constrained();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
        });
    }
};
