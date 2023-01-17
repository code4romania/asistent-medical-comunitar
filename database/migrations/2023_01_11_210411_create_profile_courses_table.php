<?php

declare(strict_types=1);

use App\Enums\CourseType;
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
        Schema::create('profile_courses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('theme');
            $table->string('provider');
            $table->enum('type', CourseType::values());
            $table->integer('credits');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
        });
    }
};
