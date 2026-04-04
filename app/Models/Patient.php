<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Appointment;

class Patient extends Model
{
    use SoftDeletes;
    protected $table = 'patients';
    protected $primaryKey = 'patient_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'contact_no',
        'image_filename',
        'date_of_birth',
        'occupation',
        'marital_status',
        'guardian_name',
        'sex',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'deleted_at' => 'datetime'
    ];

    // Patient - Appointment (1:M)
    public function appointments(): HasMany {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
}
