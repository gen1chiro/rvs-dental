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
        'slot',
        'status',
        'remarks'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
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

    public function appointmentProcedures()
    {
        return $this->hasMany(AppointmentProcedure::class, 'appointment_id');
    }

    public function procedures()
    {
        return $this->belongsToMany(DentalProcedure::class, 'appointment_procedures', 'appointment_id', 'procedure_id')
            ->withPivot('notes')
            ->withTimestamps();
    }

    public function procedureFiles() {
        return $this->hasMany(ProcedureFile::class, 'appointment_id', 'appointment_id');
    }
    // --- Accessors ---

    public function getProcedureTypeAttribute(): string
    {
        return $this->procedures->first()?->name ?? 'N/A';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'Completed' => 'text-success',
            'Scheduled' => 'text-pending',
            'Cancelled' => 'text-danger',
            'No Show'   => 'text-muted',
            default     => 'text-blue-500',
        };
    }

    public function getPatientFullNameAttribute(): string
    {
        return $this->patient 
            ? "{$this->patient->first_name} {$this->patient->last_name}" 
            : 'Unknown Patient';
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
