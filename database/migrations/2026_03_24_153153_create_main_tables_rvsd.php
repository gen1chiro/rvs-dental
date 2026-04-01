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
            $table->string('full_name');
            $table->text('address');
            $table->string('contact_no');
            $table->date('date_of_birth');
            $table->string('occupation');
            $table->string('marital_status');
            $table->string('guardian_name')->nullable();
            $table->string('sex');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dentists', function (Blueprint $table) {
            $table->id('dentist_id');
            $table->string('full_name');
            $table->string('license_no'); 
            $table->timestamps();
        });
 
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->foreignId('patient_id')->constrained('patients', 'patient_id');
            $table->foreignId('dentist_id')->constrained('dentists', 'dentist_id');
            $table->dateTime('scheduled_at');
            $table->string('status');
            $table->timestamps();
        });
        
        Schema::create('dental_procedures', function (Blueprint $table) {
            $table->id('procedure_id');
            $table->string('name');
            $table->decimal('base_price', 10, 2);
            $table->timestamps();
        });

        Schema::create('dental_certificates', function (Blueprint $table) {
            $table->id('issuance_id');
            $table->foreignId('appointment_id')->constrained('appointments', 'appointment_id');
            $table->text('recommendations');
            $table->dateTime('issued_at');
            $table->timestamps();
        });

        Schema::create('transaction_ledger', function (Blueprint $table) {
            $table->id('entry_id');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments', 'appointment_id');
            $table->date('entry_date');
            $table->text('description');
            $table->decimal('debit', 10, 2)->default(0);
            $table->decimal('credit', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Drop in reverse order to prevent FK errors later
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_ledger');
        Schema::dropIfExists('dental_certificates');
        Schema::dropIfExists('dental_procedures');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('dentists');
        Schema::dropIfExists('patients');
    }
};
