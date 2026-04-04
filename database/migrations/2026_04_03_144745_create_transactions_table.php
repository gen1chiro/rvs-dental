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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->foreignId('ledger_id')
                ->constrained('ledger', 'ledger_id')
                ->restrictOnDelete();
            $table->text('description')
                ->nullable();
            $table->enum('mode_of_payment',['cash','gcash','card'])
                ->nullable(); //Amo pa lng ni na mga MOP gina kwa nila 
            $table->decimal('debit_amount', 10, 2);
            $table->decimal('credit_amount', 10, 2);
            $table->decimal('running_balance', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
