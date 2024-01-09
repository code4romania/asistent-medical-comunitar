<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\County;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name')->virtualAs(<<<'SQL'
                NULLIF(CONCAT_WS(" ", first_name, last_name), " ")
            SQL);

            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('password_set_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->string('role');

            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('cnp', 13)->nullable()->unique();

            $table->foreignIdFor(County::class)->nullable()->constrained();
            $table->foreignIdFor(City::class)->nullable()->constrained();

            $table->string('accreditation_number')->nullable();
            $table->date('accreditation_date')->nullable();
        });
    }
};
