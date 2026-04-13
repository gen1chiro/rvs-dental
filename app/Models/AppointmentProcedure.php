<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function procedure(): BelongsTo
    {
        return $this->belongsTo(DentalProcedure::class, 'procedure_id');
    }

    public function ledgers(): HasMany
    {
        return $this->hasMany(Ledger::class, 'appointment_procedure_id');
    }
}
