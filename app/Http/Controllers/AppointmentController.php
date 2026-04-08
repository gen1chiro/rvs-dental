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
        $sort = $request->query('sort', 'asc');
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'asc';
        $search = $request->query('search');
        $date = $request->query('date');

        $query = Appointment::with(['patient', 'dentist']);

        if ($search) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where(function($inner) use ($search) {
                    $inner->where('first_name', 'like', "%{$search}%")
                          ->orWhere('last_name', 'like', "%{$search}%")
                          ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                });
            });
        }

        if ($date) {
            $query->whereDate('scheduled_at', $date);
        }

        $rawAppointments = $query->orderBy('scheduled_at', $sort)
            ->paginate(10)
            ->withQueryString();

        $rawAppointments->getCollection()->transform(function ($appointment) {
            $color = match($appointment->status) {
                'Completed' => 'text-success',
                'Scheduled' => 'text-pending',
                'Cancelled' => 'text-danger',
                'No Show'   => 'text-muted',
                default     => 'text-blue-500',
            };

            return [
                'appointment_id' => $appointment->appointment_id,
                'date'        => Carbon::parse($appointment->scheduled_at)->format('F j, Y'),
                'name'        => $appointment->patient
                    ? "{$appointment->patient->first_name} {$appointment->patient->last_name}"
                    : 'Unknown Patient',
                'remarks' => $appointment->remarks ?? 'No remarks provided.',
                'status'      => $appointment->status,
                'color'       => $color,
            ];
        });

        if ($request->ajax()) {
            $grouped = $rawAppointments->getCollection()->groupBy('date');

            if ($grouped->isEmpty()) {
                return response('', 204);
            }

            return response(view('components.appointments.list', ['appointments' => $grouped])->render())
                ->header('X-Has-More', $rawAppointments->hasMorePages() ? '1' : '0');
        }

        return view('pages.appointments', [
            'appointments' => $rawAppointments->groupBy('date'),
            'hasMore' => $rawAppointments->hasMorePages()
        ]);
    }

    public function create() {
        return view('pages.appointments.create');
    }

    public function store(StoreAppointmentRequest $request) {
        Appointment::create($request->validated());

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function edit() {
        return view('pages.appointments.edit');
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment) {

    }

    public function show($id)
    {
        $appointment = Appointment::with('patient', 'dentist')->findOrFail($id);

        return response()->json([
            'id' => $appointment->appointment_id,
            'patient_name' => "{$appointment->patient->first_name} {$appointment->patient->last_name}",
            'dentist_name' => "{$appointment->dentist->first_name} {$appointment->dentist->last_name}"?? 'N/A',
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

        $grouped = $appointments->groupBy(function ($appt) {
            return Carbon::parse($appt->scheduled_at)->format('Y-m-d');
        })->map(function ($dayAppointments) {
            return $dayAppointments->map(function ($appt) {
                return [
                    'id' => $appt->appointment_id,
                    'patient_name' => "{$appt->patient->first_name} {$appt->patient->last_name}",
                    'status' => $appt->status,
                ];
            });
        });

        return response()->json($grouped);
    }

}
