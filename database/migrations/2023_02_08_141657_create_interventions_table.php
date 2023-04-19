<?php

declare(strict_types=1);

use App\Models\Beneficiary;
use App\Models\Intervention\OcasionalBeneficiaryIntervention;
use App\Models\Service\Service;
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
        Schema::create('interventions_ocasional', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date')->nullable();
            $table->string('reason')->nullable();

            $table->foreignIdFor(Beneficiary::class)->constrained();
        });

        Schema::create('interventions_regular', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date')->nullable();
            $table->boolean('is_case');
            $table->string('reason')->nullable();

            $table->foreignIdFor(Beneficiary::class)->constrained();
        });

        Schema::create('intervention_service', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OcasionalBeneficiaryIntervention::class)->constrained('interventions_ocasional', 'id', 'intervention_service_ocasional_id_foreign');
            $table->foreignIdFor(Service::class)->constrained();
        });
    }
};
