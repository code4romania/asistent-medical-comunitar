<?php

declare(strict_types=1);

use App\Enums\Report\Status;
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
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->string('status')->default(Status::PENDING);
            $table->renameColumn('columns', 'indicators');
        });
    }
};
