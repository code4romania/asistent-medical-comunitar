<?php

declare(strict_types=1);

use App\Enums\Beneficiary\Status;
use App\Models\City;
use App\Models\County;
use App\Models\Family;
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
            $table->string('full_name')->virtualAs(<<<'SQL'
                NULLIF(CONCAT_WS(" ", first_name, last_name), " ")
            SQL);

            $table->boolean('integrated')->default(false);

            $table->string('type')->nullable();
            $table->string('status')->default(Status::REGISTERED->value);

            $table->string('cnp', 13)->nullable()->unique();
            $table->string('id_type')->nullable();
            $table->string('id_serial')->nullable();
            $table->string('id_number')->nullable();

            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('ethnicity')->nullable();

            $table->foreignIdFor(County::class)->nullable()->constrained();
            $table->foreignIdFor(City::class)->nullable()->constrained();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();

            $table->foreignIdFor(User::class, 'nurse_id')->constrained('users');
            $table->foreignIdFor(Family::class)->nullable()->constrained()->nullOnDelete();

            $table->text('reason_removed')->nullable();
            $table->text('notes')->nullable();
        });
    }
};
