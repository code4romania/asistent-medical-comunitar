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
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->timestamp('started_at');
            $table->timestamp('ended_at');

            $table->string('type')->nullable();
            $table->string('location')->nullable();
            $table->string('attendant')->nullable();
            $table->text('notes')->nullable();

            $table->foreignIdFor(Beneficiary::class)->constrained();
            $table->foreignIdFor(User::class, 'nurse_id')->constrained('users');
        });
    }
};
