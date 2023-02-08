<?php

declare(strict_types=1);

use App\Models\Beneficiary;
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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('reason')->nullable();
            $table->json('services')->nullable(); // TODO: convert to relationship
            $table->date('date')->nullable();

            $table->foreignIdFor(Beneficiary::class)->constrained();
        });
    }
};
