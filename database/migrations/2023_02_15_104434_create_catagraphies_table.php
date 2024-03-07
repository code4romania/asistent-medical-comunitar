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

            $table->string('cat_age')->nullable();
            $table->string('cat_as')->nullable();
            $table->json('cat_cr')->nullable();
            $table->boolean('has_disabilities')->nullable();
            $table->string('cat_edu')->nullable();
            $table->json('cat_fam')->nullable();
            $table->string('cat_id')->nullable();
            $table->string('cat_inc')->nullable();
            $table->json('cat_liv')->nullable();
            $table->string('cat_mf')->nullable();
            $table->json('cat_ns')->nullable();
            $table->string('cat_pov')->nullable();
            $table->json('cat_preg')->nullable();
            $table->string('cat_rep')->nullable();
            $table->boolean('has_health_issues')->nullable();
            $table->json('cat_ssa')->nullable();
            $table->json('cat_vif')->nullable();

            $table->text('notes')->nullable();

            $table->foreignIdFor(User::class, 'nurse_id')->constrained('users');
            $table->foreignIdFor(Beneficiary::class)->constrained();
        });
    }
};
