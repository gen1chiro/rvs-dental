<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentProcedureRequest;
use App\Models\AppointmentProcedure;

class AppointmentProcedureController extends Controller
{
    public function store(StoreAppointmentProcedureRequest $request) {
        return back()->with('success', 'Procedure added successfully.');
    }
}
