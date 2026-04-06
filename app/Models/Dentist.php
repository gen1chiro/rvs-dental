<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dentist extends Model
{
    protected $table = 'dentists';
    protected $primaryKey = 'dentist_id';

    protected $fillable = ['full_name', 'license_no'];
}
