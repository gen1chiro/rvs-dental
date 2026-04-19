<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class ProcedureFileController extends Controller
{
    public function save(Request $request, Appointment $appointment) {
        $request->validate([
            'images.*' => 'required|image|max:10240'
        ]);
        
        DB::transaction(function () use ($request, $appointment) {
            foreach($request->file('images', []) as $file) {
                $path = $file->store("appointments/{$appointment->appointment_id}", 'public');
                $appointment->procedureFiles()->create([
                    'file_name' => basename($path),
                    'file_type' => $file->getClientMimeType()
                ]);
            }
        });

        return back()->with('success', 'Images uploaded successfully.');
    }
}
