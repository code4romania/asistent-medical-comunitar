<?php

declare(strict_types=1);

use App\Enums\StudyType;
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
        Schema::create('profile_studies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->enum('type', StudyType::values());
            $table->string('institution')->nullable();
            $table->foreignIdFor(County::class)->nullable()->constrained();
            $table->foreignIdFor(City::class)->nullable()->constrained();
            $table->unsignedTinyInteger('duration')->nullable();
            $table->year('start_year')->nullable();
            $table->year('end_year')->nullable();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
        });
    }
};
