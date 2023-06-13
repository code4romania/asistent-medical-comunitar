<?php

declare(strict_types=1);

use App\Enums\Intervention\CaseInitiator;
use App\Models\Appointment;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Models\Service\Service;
use App\Models\Vulnerability\Vulnerability;
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
        // Ocasional Beneficiary // Interventions
        Schema::create('ocasional_interventions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date')->nullable();
            $table->string('reason')->nullable();

            $table->foreignIdFor(Beneficiary::class)->constrained();
        });

        Schema::create('ocasional_intervention_service', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Intervention\OcasionalIntervention::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Service::class)->constrained();
        });

        // // // // // // // // // // // // // // // // // // // // // // // // //s

        // Regular Beneficiary // Interventions // Cases
        Schema::create('interventionable_cases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('closed_at')->nullable();
            $table->string('name')->nullable();
            $table->enum('initiator', CaseInitiator::values())->nullable();
            $table->boolean('integrated')->default(false);
            $table->boolean('is_imported')->default(false);
            $table->text('notes')->nullable();
        });

        // Regular Beneficiary // Interventions // Individual
        Schema::create('interventionable_individual_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date')->nullable();
            $table->boolean('integrated')->default(false);
            $table->boolean('outside_working_hours')->default(false);
            $table->string('status')->nullable();
            $table->text('notes')->nullable();

            $table->foreignIdFor(Service::class)->nullable()->constrained();
        });

        //
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('interventionable_type');
            $table->unsignedBigInteger('interventionable_id');
            $table->unique(['interventionable_type', 'interventionable_id']);

            $table->foreignIdFor(Beneficiary::class)->nullable()->constrained();
            $table->foreignIdFor(Vulnerability::class)->nullable()->constrained();
            $table->foreignIdFor(Appointment::class)->nullable()->constrained();
            $table->foreignIdFor(Intervention::class, 'parent_id')->nullable()->constrained('interventions');
        });
    }
};
