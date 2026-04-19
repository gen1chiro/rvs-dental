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
        Schema::table('appointment_procedures', function (Blueprint $table) {
            $table->dropColumn('charged_price'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_procedures', function (Blueprint $table) {
            $table->decimal('charged_price')
                ->after('notes')
                ->default(0.0);
        });
    }
};
