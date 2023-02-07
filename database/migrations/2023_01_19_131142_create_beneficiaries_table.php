<?php

declare(strict_types=1);

use App\Enums\Beneficiary\IDType;
use App\Enums\Beneficiary\Status;
use App\Enums\Beneficiary\Type;
use App\Enums\Gender;
use App\Models\City;
use App\Models\County;
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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('prior_name')->nullable();
            $table->boolean('integrated')->default(false);

            $table->enum('type', Type::values())->nullable();
            $table->enum('status', Status::values())->default(Status::REGISTERED->value);

            $table->string('cnp', 13)->nullable()->unique();
            $table->enum('id_type', IDType::values());
            $table->string('id_serial')->nullable();
            $table->string('id_number')->nullable();

            $table->enum('gender', Gender::values())->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('ethnicity')->nullable();

            $table->foreignIdFor(County::class)->nullable()->constrained();
            $table->foreignIdFor(City::class)->nullable()->constrained();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();

            $table->foreignIdFor(User::class, 'amc_id')->constrained('users');

            $table->text('notes')->nullable();
        });
    }
};
