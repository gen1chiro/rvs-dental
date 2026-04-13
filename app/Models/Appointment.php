<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'patient_id',
        'dentist_id',
        'scheduled_at',
        'status',
        'remarks'
    ];

    // --- Relationships ---

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function dentist()
    {
        return $this->belongsTo(Dentist::class, 'dentist_id');
    }

    public function procedures()
    {
        return $this->belongsToMany(DentalProcedure::class, 'appointment_procedures', 'appointment_id', 'procedure_id')
            ->withPivot('notes', 'charged_price')
            ->withTimestamps();
    }

    // --- Accessors ---

    public function getProcedureTypeAttribute()
    {
        return $this->procedures->first()?->name ?? 'N/A';
    }

    // --- Scopes ---

    public function scopeSearchByPatient($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->whereHas('patient', function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
        });
    }

    public function scopeFilterByDate($query, $date)
    {
        if (!$date) {
            return $query;
        }

        return $query->whereDate('scheduled_at', $date);
    }
}
