<?php

declare(strict_types=1);

use App\Models\County;
use Database\Seeders\SirutaCitiesSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(County::class)->constrained();
            $table->string('name');
        });
        (new SirutaCitiesSeeder())->run();
    }
};
