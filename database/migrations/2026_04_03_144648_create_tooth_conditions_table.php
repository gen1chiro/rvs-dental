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
        Schema::create('tooth_conditions', function (Blueprint $table) {
            $table->id('tooth_condition_id');
            $table->foreignId('appointment_id')
                ->constrained('appointments', 'appointment_id')
                ->restrictOnDelete();
            $table->unsignedTinyInteger('tooth_id');
            $table->foreign('tooth_id')
                ->references('tooth_id')
                ->on('tooth_numbering')
                ->restrictOnDelete();
            $table->text('notes')
                ->nullable();
            $table->string('condition');
            $table->string('treatment');
            $table->unsignedTinyInteger('tooth_part');
            $table->timestamps();

            $table->unique(['appointment_id', 'tooth_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tooth_conditions');
    }
};
