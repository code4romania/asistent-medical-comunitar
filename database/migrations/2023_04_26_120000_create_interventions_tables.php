<?php

declare(strict_types=1);

use App\Enums\Intervention\CaseInitiator;
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

        // Regular Beneficiary // Interventions // Case Management
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('closed_at')->nullable();
            $table->string('name')->nullable();
            $table->enum('initiator', CaseInitiator::values())->nullable();
            $table->boolean('integrated')->default(false);
            $table->boolean('imported')->default(false);
            $table->text('notes')->nullable();

            $table->foreignIdFor(Beneficiary::class)->constrained();
            $table->foreignIdFor(Vulnerability::class)->default('NONE')->constrained();
        });

        // Regular Beneficiary // Interventions // Individual
        Schema::create('individual_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date')->nullable(); //
            $table->boolean('integrated')->default(false); //
            $table->boolean('outside_working_hours')->default(false); //
            $table->string('status')->nullable();
            $table->text('notes')->nullable();

            $table->foreignIdFor(Intervention\CaseManagement::class, 'case_id')->nullable()->constrained('cases'); //
            $table->foreignIdFor(Beneficiary::class)->nullable()->constrained();
            $table->foreignIdFor(Service::class)->nullable()->constrained(); //
            $table->foreignIdFor(Vulnerability::class)->nullable()->constrained(); //
        });
    }
};
