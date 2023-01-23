<?php

declare(strict_types=1);

use App\Imports\SirutaImport;
use App\Models\City;
use App\Models\County;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siruta');
            $table->string('name');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(County::class)->constrained();
            $table->tinyInteger('level')->unsigned();
            $table->tinyInteger('type')->unsigned();
            $table->foreignIdFor(City::class, 'parent_id')->nullable()->constrained('cities');
            $table->string('name');
        });

        Schema::withoutForeignKeyConstraints(function () {
            Excel::import(new SirutaImport, database_path('siruta/SIR_DIACRITIC.xlsx'));
        });
    }
};
