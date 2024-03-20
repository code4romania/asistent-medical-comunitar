<?php

declare(strict_types=1);

use App\Models\County;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('community_activities', function (Blueprint $table) {
            $table->foreignIdFor(User::class, 'nurse_id')->nullable()->constrained('users');
            $table->dropConstrainedForeignIdFor(County::class);
        });
    }
};
