<?php

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
        Schema::table('ledger', function (Blueprint $table) {
            $table->decimal('charged_price', 10)
                ->after('description')
                ->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ledger', function (Blueprint $table) {
            $table->dropColumn('charged_price');
        });
    }
};
