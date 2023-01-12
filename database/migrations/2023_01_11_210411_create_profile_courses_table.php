<?php

use App\Enums\CourseType;
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
        Schema::create('profile_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->year('year');
            $table->string('provider');
            $table->string('name');
            $table->enum('type', CourseType::values());
            $table->integer('credits');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

};
