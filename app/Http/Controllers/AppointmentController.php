<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View|Response
    {
        $sort = $request->query('sort', 'asc') === 'desc' ? 'desc' : 'asc';
        $status = $request->query('status', 'Scheduled');

        $rawAppointments = Appointment::with(['patient', 'dentist'])
            ->searchByPatient($request->query('search'))
            ->filterByDate($request->query('date'))
            ->when($status !== 'All', fn($q) => $q->where('status', $status))
            ->orderBy('scheduled_at', $sort)
            ->paginate(10)
            ->withQueryString();

        // Transform collection for the list view
        $rawAppointments->getCollection()->transform(fn($appointment) => [
            'appointment_id' => $appointment->appointment_id,
            'date'           => $appointment->scheduled_at->format('F j, Y'),
            'name'           => $appointment->patient_full_name,
            'remarks'        => $appointment->remarks ?? 'No remarks provided.',
            'status'         => $appointment->status,
            'color'          => $appointment->status_color,
        ]);

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

    public function create(): View
    {
        return view('pages.appointments.create');
    }

    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::create($request->validated());

        return redirect()->route('appointments.view', $appointment)
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['patient', 'dentist', 'procedures']);

        return view('components.appointments.detail', compact('appointment'));
    }

    public function edit(Appointment $appointment): View
    {
        $appointment->load('patient');
        return view('pages.appointments.edit', compact('appointment'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());

        return redirect()->route('appointments.view', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }

    public function calendar(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        $appointments = Appointment::with('patient')
            ->whereMonth('scheduled_at', $month)
            ->whereYear('scheduled_at', $year)
            ->get()
            ->groupBy(fn($appt) => $appt->scheduled_at->format('Y-m-d'));

        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.appointments.calendar-grid', compact('appointments', 'month', 'year'))->render(),
                'monthName' => Carbon::create($year, $month, 1)->format('F Y'),
            ]);
        }

        return view('components.appointments.calendar-grid', compact('appointments', 'month', 'year'));
    }

    public function generate(Appointment $appointment)
    {
        $appointment->load([
            'patient',
            'dentist',
            'appointmentProcedures.dentalProcedure'
        ]);

        return view('pages.appointments.generate', compact('appointment'));
    }

    public function view(Appointment $appointment) {
        return view('pages.appointments.view', compact('appointment'));
    }
 
    public function uploadProcedureImages(Request $request, Appointment $appointment) {
        $request->validate([
            'image' => 'required|array',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:10240'
        ]);

        if ($request->hasFile('images')) {
            foreach($request->file('images') as $image) {
                $folder = "appointments/{$appointment->appointment_id}";
                $path = $image->store($folder, 'public');

                $appointment->procedureFiles()->create([
                    'appointment_id' => $appointment->appointment_id,
                    'file_name' => basename($path),
                    'file_type' => $image->getClientMimeType()
                ]);
            }
        }

        return back()->with('Success', 'Images uploaded successfully.');
    }
}
