<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'ledger_id',
        'description',
        'mode_of_payment',
        'debit_amount',
        'credit_amount',
        'running_balance'
    ];

    public function ledger(): BelongsTo
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }

    public function getPatientAttribute()
    {
        return $this->ledger?->appointmentProcedure?->appointment?->patient;
    }

    public function getStatusAttribute()
    {
        return $this->ledger?->appointmentProcedure?->appointment?->status ?? 'N/A';
    }
}
