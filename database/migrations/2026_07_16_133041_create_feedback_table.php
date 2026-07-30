<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\County;
use App\Models\FeedbackCategory;
use App\Models\FeedbackSubcategory;
use App\Models\User;
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
        Schema::create('feedback_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('feedback_subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->foreignIdFor(FeedbackCategory::class, 'category_id')
                ->constrained();
        });

        FeedbackCategory::insert([
            ['name' => 'Interacțiunea cu asistentul medical comunitar'],
            ['name' => 'Interacțiunea cu medicul de familie'],
            ['name' => 'Altele'],
        ]);

        FeedbackCategory::query()
            ->where('name', 'Interacțiunea cu medicul de familie')
            ->first()
            ->subcategories()
            ->createMany([
                ['name' => 'Refuză furnizarea serviciilor medicale'],
                ['name' => 'Nu este înscris pe lista medicului de familie'],
                ['name' => 'Nu i s-a dat bilet de trimitere'],
                ['name' => 'Altele'],
            ]);

        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');

            $table->foreignIdFor(FeedbackCategory::class, 'category_id')
                ->constrained();

            $table->foreignIdFor(FeedbackSubcategory::class, 'subcategory_id')
                ->nullable()
                ->constrained();

            $table->text('description');

            $table->foreignIdFor(County::class)
                ->constrained();

            $table->foreignIdFor(City::class)
                ->constrained();

            $table->foreignIdFor(User::class)
                ->constrained();
        });
    }
};
