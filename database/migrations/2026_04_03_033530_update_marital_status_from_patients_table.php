<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE patients MODIFY COLUMN marital_status ENUM('Single','Married','Widowed','Separated') NOT NULL");
        DB::statement("ALTER TABLE patients MODIFY COLUMN sex ENUM('Male','Female') NOT NULL");

        Schema::table('patients', function (Blueprint $table) {
            $table->string('image_filename')
                ->nullable()
                ->after('last_name')
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE patients MODIFY COLUMN marital_status VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE patients MODIFY COLUMN sex VARCHAR(255) NOT NULL");

        Schema::table('patients', function (Blueprint $table) {

            $table->dropColumn('image_filename');
        });
    }
};
