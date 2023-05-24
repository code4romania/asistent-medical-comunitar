<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('community_activities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type');
            $table->string('name');
            $table->date('date');
            $table->boolean('outside_working_hours')->default(false);
            $table->string('location')->nullable();
            $table->string('organizer')->nullable();
            $table->unsignedSmallInteger('participants')->nullable();
            $table->string('participants_list')->nullable();
            $table->text('notes')->nullable();
        });
    }
};
