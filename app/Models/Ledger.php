<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ledger extends Model
{
    protected $table = 'ledger';
    protected $primaryKey = 'ledger_id';

    protected $fillable = [
        'appointment_procedure_id',
        'description',
        'charged_price'
    ];

    public function appointmentProcedure(): BelongsTo
    {
        return $this->belongsTo(AppointmentProcedure::class, 'appointment_procedure_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'ledger_id');
    }
}
