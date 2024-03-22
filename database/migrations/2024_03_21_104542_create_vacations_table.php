<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('notes')->nullable();
            $table->foreignIdFor(User::class, 'nurse_id')->nullable()->constrained('users');
        });
    }
};
