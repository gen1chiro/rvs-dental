<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AppointmentProcedure extends Model
{
    protected $table = 'appointment_procedures';
    protected $primaryKey = 'appointment_procedure_id';

    protected $fillable = [
        'appointment_id',
        'procedure_id',
        'notes',
        'charged_price'
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function ledgers(): HasOne
    {
        return $this->hasOne(Ledger::class, 'appointment_procedure_id');
    }
    
    public function dentalProcedure(): BelongsTo
    {
        return $this->belongsTo(DentalProcedure::class, 'procedure_id');
    }
}
