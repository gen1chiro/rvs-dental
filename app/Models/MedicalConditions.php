<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalConditions extends Model
{
    protected $table = 'medical_conditions';

    protected $fillable = ['condition_name'];
}
