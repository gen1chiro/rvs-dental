<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DentalCertificate;
use App\Http\Requests\StoreDentalCertificateRequest;
use App\Models\Appointment;

class DentalCertificateController extends Controller
{
    public function store(StoreDentalCertificateRequest $request, Appointment $appointment)
    {
        $validated = $request->validated();

        DentalCertificate::firstOrCreate(
            ['appointment_id' => $validated['appointment_id']],
            [
                'recommendations' => $validated['recommendation'],
                'issued_at' => now(),
            ]
        );

        return back()->withInput()->with('print', true);
    }
}
