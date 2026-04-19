<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentProcedureRequest;
use Illuminate\Support\Facades\DB;
use App\Models\AppointmentProcedure;
use App\Models\Appointment;

class AppointmentProcedureController extends Controller
{
    public function store(StoreAppointmentProcedureRequest $request, Appointment $appointment) {
        DB::transaction(function () use ($request, $appointment) {
            $procedure = AppointmentProcedure::create([
                'appointment_id' => $appointment->appointment_id,
                ...$request->validated()
            ]);
    
            $procedure->ledger()->create([
                'description' => $request->ledger_description,
                'charged_price' => $request->charged_price
            ]);
        });
        return back()->with('success', 'Procedure added successfully.');
    }
}
