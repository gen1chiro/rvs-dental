<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dentist extends Model
{
    protected $table = 'dentists';
    protected $primaryKey = 'dentist_id';

    protected $fillable = [
        'first_name', 
        'last_name', 
        'license_no'
    ];

    protected $appends = ['full_name'];
    public function getFullNameAttribute(): string {
        return "{$this->first_name} {$this->last_name}";
    }

}
