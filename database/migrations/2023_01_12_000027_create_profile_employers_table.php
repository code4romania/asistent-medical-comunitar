<?php

use App\Enums\EmployerType;
use App\Models\City;
use App\Models\County;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_employers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('name');
            $table->enum('type', EmployerType::values());
            $table->string('project_name')->nullable();
            $table->foreignIdFor(County::class);
            $table->foreignIdFor(City::class);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }
};
