<?php

namespace App\Http\Controllers;

use App\Models\DentalProcedure;

class ProcedureController extends Controller
{
    public function index() {
        $procedures = DentalProcedure::select([
            'procedure_id', 
            'name', 
            'min_price', 
            'max_price', 
            'notes'
        ])
        ->orderBy('name', 'asc')
        ->get();
        return response()->json($procedures);
    }
}
