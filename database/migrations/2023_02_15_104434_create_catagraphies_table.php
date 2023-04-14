<?php

declare(strict_types=1);

use App\Models\Beneficiary;
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
        Schema::create('catagraphies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('evaluation_date');
            $table->string('id_type')->nullable();
            $table->string('age_category')->nullable();
            $table->string('income')->nullable();
            $table->string('poverty')->nullable();
            $table->string('habitation')->nullable();
            $table->json('family')->nullable();
            $table->string('education')->nullable();
            $table->json('domestic_violence')->nullable();
            $table->string('social_health_insurance')->nullable();
            $table->string('family_doctor')->nullable();
            $table->string('disability')->nullable();
            $table->text('notes')->nullable();

            $table->foreignIdFor(User::class, 'nurse_id')->constrained('users');
            $table->foreignIdFor(Beneficiary::class)->constrained();
        });
    }
};
