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
        Schema::create('patients', function (Blueprint $table) {
            $table->id('patient_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('sex', ['Male', 'Female']);
            $table->text('address');
            $table->string('contact_number');
            $table->string('occupation');
            $table->enum('marital_status', ['Single', 'Married', 'Widowed', 'Separated']);
            $table->string('guardian_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dentists', function (Blueprint $table) {
            $table->id('dentist_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('license_number');
            $table->string('specialization');
            $table->timestamps();
        });
        
        Schema::create('dental_procedures', function (Blueprint $table) {
            $table->id('procedure_id');
            $table->string('name');
            $table->decimal('min_price', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('tooth_numbering', function (Blueprint $table) {
            $table->tinyInteger('tooth_id')->unsigned();
            $table->enum('type', ['Permanent', 'Temporary']);
            $table->enum('quadrant', ['Upper Right', 'Upper Left', 'Lower Right', 'Lower Left']);
            $table->tinyInteger('position')->unsigned();
            $table->timestamps();
        });

        Schema::create('medical_conditions', function (Blueprint $table) {
            $table->id('condition_id');
            $table->string('condition_name');
            $table->timestamps();
        });

        Schema::create('medical_questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->string('question');
            $table->timestamps();
        });

    }

    /**
     * Drop in reverse order to prevent FK errors later
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
        Schema::dropIfExists('dentists');
        Schema::dropIfExists('dental_procedures');
        Schema::dropIfExists('medical_conditions');
        Schema::dropIfExists('medical_questions');
        Schema::dropIfExists('tooth_numbering');
    }
};
