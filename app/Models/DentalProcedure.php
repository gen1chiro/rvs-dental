<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalProcedure extends Model
{
    protected $table = 'dental_procedures';
    protected $primaryKey = 'procedure_id';

    protected $fillable = [
        'name',
        'min_price',
        'max_price',
        'notes'
    ];
}
