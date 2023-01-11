<?php

use App\Enums\StudyType;
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
        Schema::create('profile_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('name');
            $table->enum('type', StudyType::values());
            $table->string('emitted_institution');
            $table->integer('duration');
            $table->foreignIdFor(County::class);
            $table->foreignIdFor(City::class);
            $table->year('start_year')->nullable();
            $table->year('end_year')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_studies');
    }
};
