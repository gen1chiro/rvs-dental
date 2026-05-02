<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\MedicalCondition;
use App\Models\MedicalQuestion;
use App\Models\PatientCondition;
use App\Models\PatientResponse;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View|Response
    {
        $sort = $request->query('sort', 'asc') === 'desc' ? 'desc' : 'asc';
        $status = $request->query('status', 'Scheduled');

        $rawAppointments = Appointment::with(['patient', 'dentist'])
            ->whereHas('patient') // Get appointments with active patients only
            ->searchByPatient($request->query('search'))
            ->filterByDate($request->query('date'))
            ->when($status !== 'All', fn ($q) => $q->where('status', $status))
            ->orderBy('scheduled_at', $sort)
            ->paginate(10)
            ->withQueryString();

        // Transform collection for the list view
        $rawAppointments->getCollection()->transform(fn ($appointment) => [
            'appointment_id' => $appointment->appointment_id,
            'date' => $appointment->scheduled_at->format('F j, Y'),
            'name' => $appointment->patient_full_name,
            'remarks' => $appointment->remarks ?? 'No remarks provided.',
            'status' => $appointment->status,
            'color' => $appointment->status_color,
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
            ->whereHas('patient') // Get appointments with active patients only
            ->whereMonth('scheduled_at', $month)
            ->whereYear('scheduled_at', $year)
            ->get()
            ->groupBy(fn ($appt) => $appt->scheduled_at->format('Y-m-d'));

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
            'appointmentProcedures.dentalProcedure',
        ]);

        return view('pages.appointments.generate', compact('appointment'));
    }

    public function view(Appointment $appointment)
    {
        $appointment->load([
            'appointmentProcedures.dentalProcedure',
            'appointmentProcedures.ledger',
        ]);

        return view('pages.appointments.view', compact('appointment'));
    }

    public function medicalForm(Appointment $appointment): View
    {
        $appointment->loadMissing('patient');
        $isFemale = strtolower((string) $appointment->patient?->sex) === 'female';

        $questions = MedicalQuestion::query()
            ->select('question_id', 'question')
            ->orderBy('question_id')
            ->get();

        $conditions = MedicalCondition::query()
            ->select('id', 'condition_name')
            ->get();

        $existingResponses = $appointment->medicalResponses()
            ->get()
            ->keyBy('question_id');

        $existingConditionIds = $appointment->patientConditions()
            ->pluck('condition_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $otherConditionNotes = $appointment->patientConditions()
            ->whereHas('condition', fn ($query) => $query->where('condition_name', 'Others'))
            ->value('notes');

        return view('pages.appointments.medical-form', compact(
            'appointment',
            'isFemale',
            'questions',
            'conditions',
            'existingResponses',
            'existingConditionIds',
            'otherConditionNotes'
        ));
    }

    public function storeMedicalForm(Request $request, Appointment $appointment)
    {
        $radioOnly = [1, 6, 7];
        $womenOnly = [10, 11, 12];
        $radioWithNotes = [2, 3, 4, 5, 8];
        $textOnly = [9, 13, 14];
        $bloodTypeOptions = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Unknown'];
        $appointment->loadMissing('patient');
        $isFemale = strtolower((string) $appointment->patient?->sex) === 'female';
        $otherConditionId = (int) MedicalCondition::query()
            ->where('condition_name', 'Others')
            ->value('id');

        $rules = [
            'conditions' => ['nullable', 'array'],
            'conditions.*' => ['integer', 'exists:medical_conditions,id'],
            'other_condition_notes' => ['nullable', 'string'],
        ];

        $messages = [
            'responses.*.answer.required' => 'Required.',
            'responses.*.answer.in' => 'Invalid choice.',
            'responses.*.notes.required' => 'Required.',
            'responses.*.notes.required_if' => 'Note is required if answer is Yes.',
            'other_condition_notes.required' => 'Required.',
        ];

        foreach ($radioOnly as $questionId) {
            $rules["responses.{$questionId}.answer"] = ['required', 'in:Yes,No'];
            $rules["responses.{$questionId}.notes"] = ['nullable', 'string'];
        }

        if ($isFemale) {
            foreach ($womenOnly as $questionId) {
                $rules["responses.{$questionId}.answer"] = ['required', 'in:Yes,No,N/A'];
                $rules["responses.{$questionId}.notes"] = ['nullable', 'string'];
            }
        }

        foreach ($radioWithNotes as $questionId) {
            $rules["responses.{$questionId}.answer"] = ['required', 'in:Yes,No'];
            $rules["responses.{$questionId}.notes"] = [
                'nullable',
                'string',
                "required_if:responses.{$questionId}.answer,Yes",
            ];
        }

        foreach ($textOnly as $questionId) {
            $rules["responses.{$questionId}.notes"] = ['required', 'string'];
            $rules["responses.{$questionId}.answer"] = ['nullable', 'in:Yes,No,N/A'];
        }

        $rules['responses.13.notes'] = ['required', 'in:' . implode(',', $bloodTypeOptions)];

        $validated = $request->validate($rules, $messages);

        $selectedConditions = collect($validated['conditions'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if ($otherConditionId !== 0 && $selectedConditions->contains($otherConditionId)) {
            $request->validate([
                'other_condition_notes' => ['required', 'string'],
            ], $messages);
        }

        $otherConditionNotes = trim((string) ($validated['other_condition_notes'] ?? $request->input('other_condition_notes', '')));

        $questionIds = array_merge(
            $radioOnly,
            $radioWithNotes,
            $textOnly,
            $isFemale ? $womenOnly : []
        );

        DB::transaction(function () use ($appointment, $validated, $questionIds, $textOnly, $selectedConditions, $otherConditionId, $otherConditionNotes) {
            foreach ($questionIds as $questionId) {
                $input = data_get($validated, "responses.{$questionId}", []);
                $notes = trim((string) data_get($input, 'notes', ''));
                $answer = data_get($input, 'answer');

                if (in_array($questionId, $textOnly, true)) {
                    $answer = 'N/A';
                }

                PatientResponse::updateOrCreate(
                    [
                        'appointment_id' => $appointment->appointment_id,
                        'question_id' => $questionId,
                    ],
                    [
                        'answer' => $answer,
                        'notes' => $notes !== '' ? $notes : null,
                    ]
                );
            }

            $appointment->patientConditions()->delete();

            if ($selectedConditions->isNotEmpty()) {
                $rows = $selectedConditions
                    ->map(fn ($conditionId) => [
                        'appointment_id' => $appointment->appointment_id,
                        'condition_id' => $conditionId,
                        'notes' => $conditionId === $otherConditionId && $otherConditionNotes !== ''
                            ? $otherConditionNotes
                            : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])
                    ->all();

                PatientCondition::insert($rows);
            }
        });

        return redirect()
            ->route('appointments.view', $appointment)
            ->with('success', 'Medical form saved successfully.');
    }

    public function uploadProcedureImages(Request $request, Appointment $appointment)
    {
        $request->validate([
            'image' => 'required|array',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:10240',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $folder = "appointments/{$appointment->appointment_id}";
                $path = $image->store($folder, 'public');

                $appointment->procedureFiles()->create([
                    'appointment_id' => $appointment->appointment_id,
                    'file_name' => basename($path),
                    'file_type' => $image->getClientMimeType(),
                ]);
            }
        }

        return back()->with('Success', 'Images uploaded successfully.');
    }

    public function forPatient(Patient $patient) {
        return $patient->relevantAppointments()->get();
    }

    public function fullDetails(Appointment $appointment) {
        $appointment->load([
            'appointmentProcedures.dentalProcedure',
            'appointmentProcedures.ledger.transactions'
        ]);

        $responseShape = [
            'appointment_id' => $appointment->appointment_id,
            'procedures' => $appointment->appointmentProcedures
                ->map(fn($ap) => [
                    'procedure_name' => $ap->dentalProcedure->name,
                    'ledger_id' => $ap->ledger->ledger_id,
                    'charged_price' => $ap->ledger->charged_price,
                    'transactions' => $ap->ledger->transactions->map(fn($tx) => [
                        'transaction_id' => $tx->transaction_id,
                        'credit' => $tx->credit_amount,
                        'debit' => $tx->debit_amount,
                        'type' => $tx->type,
                        'balance' => $tx->running_balance,
                        'mode_of_payment' => $tx->mode_of_payment,
                        'created_at' => $tx->created_at->format('M d, Y'),
                    ])
                ]),
        ];

        return response()->json($responseShape);
    }
}
