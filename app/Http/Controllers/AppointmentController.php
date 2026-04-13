<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'asc') === 'desc' ? 'desc' : 'asc';

        $rawAppointments = Appointment::with(['patient', 'dentist'])
            ->searchByPatient($request->query('search'))
            ->filterByDate($request->query('date'))
            ->orderBy('scheduled_at', $sort)
            ->paginate(10)
            ->withQueryString();

        // Transform the collection using a dedicated private method
        $rawAppointments->getCollection()->transform(fn($appointment) => $this->formatForList($appointment));

        $appointments = $rawAppointments->getCollection()->groupBy('date');

        if ($request->ajax()) {
            if ($appointments->isEmpty()) {
                return response('', 204);
            }

            return response(view('components.appointments.list', compact('appointments'))->render())
                ->header('X-Has-More', $rawAppointments->hasMorePages() ? '1' : '0');
        }

        return view('pages.appointments', [
            'appointments' => $appointments,
            'hasMore' => $rawAppointments->hasMorePages(),
        ]);
    }

    public function create()
    {
        return view('pages.appointments.create');
    }

    public function store(StoreAppointmentRequest $request)
    {
        Appointment::create($request->validated());

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    // Fixed: Added Model Binding parameter
    public function edit(Appointment $appointment)
    {
        return view('pages.appointments.edit', compact('appointment'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function show($id)
    {
        $appointment = Appointment::with('patient', 'dentist')->findOrFail($id);

        return response()->json([
            'id' => $appointment->appointment_id,
            'patient_name' => $appointment->patient ? "{$appointment->patient->first_name} {$appointment->patient->last_name}" : 'Unknown',
            'patient_image_url' => $appointment->patient?->image_url,
            'dentist_name' => $appointment->dentist ? "{$appointment->dentist->first_name} {$appointment->dentist->last_name}" : 'N/A',
            'remarks' => $appointment->remarks,
            'status' => $appointment->status,
            'scheduled_at' => Carbon::parse($appointment->scheduled_at)->format('F j, Y g:i A'),
        ]);
    }

    public function calendar(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        $appointments = Appointment::with('patient')
            ->whereMonth('scheduled_at', $month)
            ->whereYear('scheduled_at', $year)
            ->get();

        $grouped = $appointments->groupBy(fn($appt) => Carbon::parse($appt->scheduled_at)->format('Y-m-d'))
            ->map(fn($dayAppointments) => $dayAppointments->map(fn($appt) => [
                'id' => $appt->appointment_id,
                'patient_name' => $appt->patient ? "{$appt->patient->first_name} {$appt->patient->last_name}" : 'Unknown',
                'status' => $appt->status,
            ]));

        return response()->json($grouped);
    }

    private function formatForList(Appointment $appointment): array
    {
        $color = match($appointment->status) {
            'Completed' => 'text-success',
            'Scheduled' => 'text-pending',
            'Cancelled' => 'text-danger',
            'No Show'   => 'text-muted',
            default     => 'text-blue-500',
        };

        return [
            'appointment_id' => $appointment->appointment_id,
            'date'           => Carbon::parse($appointment->scheduled_at)->format('F j, Y'),
            'name'           => $appointment->patient
                ? "{$appointment->patient->first_name} {$appointment->patient->last_name}"
                : 'Unknown Patient',
            'remarks'        => $appointment->remarks ?? 'No remarks provided.',
            'status'         => $appointment->status,
            'color'          => $color,
        ];
    }
}
