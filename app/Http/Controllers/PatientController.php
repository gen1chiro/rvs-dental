<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Show lists of patients (Paginated + Infinite Scrolling + Search Bar)
    public function index()
    {
        $search = request()->query('search');

        $rawPatients = Patient::query()
            ->select('patients.*')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                });
            })
            ->selectSub(
                Appointment::query()
                    ->select('remarks')
                    ->whereColumn('appointments.patient_id', 'patients.patient_id')
                    ->orderByDesc('scheduled_at')
                    ->limit(1),
                'last_appointment_remarks'
            )
            ->selectSub(
                Appointment::query()
                    ->select('updated_at')
                    ->whereColumn('appointments.patient_id', 'patients.patient_id')
                    ->orderByDesc('scheduled_at')
                    ->limit(1),
                'last_appointment_updated_at'
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if (request()->ajax()) {
            $patients = $rawPatients->getCollection();

            if ($patients->isEmpty()) {
                return response('', 204);
            }

            return response(view('components.patients.list', compact('patients'))->render())
                ->header('X-Has-More', $rawPatients->hasMorePages() ? '1' : '0');
        }

        return view('pages.patients.index', [
            'patients' => $rawPatients->getCollection(),
            'hasMore' => $rawPatients->hasMorePages(),
        ]);
    }

    // Display patient add form
    public function create()
    {
        return view('pages.patients.create');
    }

    // Manage form submission from patient add form
    public function store(StorePatientRequest $request)
    {
        // Save record first to fetch for patient id - will be used in storing the patient photos
        $patient = Patient::create($request->safe()->except('image_filename'));
        // Create a specific patient directory, store the image, and update the patient image
        if ($request->hasFile('image_filename')) {
            $folder = "patients/{$patient->patient_id}";
            $imageFile = $request->file('image_filename')->store($folder, 'public');

            $patient->image_filename = basename($imageFile);
            $patient->save();
        }

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Patient added successfully.');
    }

    // Display a specific patient information
    public function show(Patient $patient)
    {
        $medicalHistoryLastUpdatedAt = DB::table('appointments')
            ->where('patient_id', $patient->patient_id)
            ->max('updated_at');

        $patientResponses = DB::table('patient_responses')
            ->join('appointments', 'appointments.appointment_id', '=', 'patient_responses.appointment_id')
            ->join('medical_questions', 'medical_questions.question_id', '=', 'patient_responses.question_id')
            ->where('appointments.patient_id', $patient->patient_id)
            ->select('patient_responses.answer', 'medical_questions.question')
            ->orderByDesc('appointments.scheduled_at')
            ->orderBy('medical_questions.question')
            ->get();

        $medicalConditions = DB::table('medical_conditions')
            ->select('id', 'condition_name')
            ->get();

        $patientConditionIds = DB::table('patient_conditions')
            ->join('appointments', 'appointments.appointment_id', '=', 'patient_conditions.appointment_id')
            ->where('appointments.patient_id', $patient->patient_id)
            ->distinct()
            ->pluck('patient_conditions.condition_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        return view('pages.patients.show', compact('patient', 'medicalHistoryLastUpdatedAt', 'patientResponses', 'medicalConditions', 'patientConditionIds'));
    }

    // Show patient edit form
    public function edit(Patient $patient)
    {
        return view('pages.patients.edit', compact('patient'));
    }

    // Manage patient update form
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $patient->update($request->safe()->except('image_filename'));
        // Delete the existing photo in the storage
        if ($request->hasFile('image_filename')) {
            if ($patient->image_filename) {
                Storage::disk('public')->delete("patients/{$patient->patient_id}/{$patient->image_filename}");
            }

            $folder = "patients/{$patient->patient_id}";
            $imageFile = $request->file('image_filename')->store($folder, 'public');

            $patient->image_filename = basename($imageFile);
            $patient->save();
        }

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Patient updated successfully.');
    }

    // Delete a specific patient (soft-deletes only)
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient removed successfully.');
    }

    public function search(Request $request): JsonResponse {
        $request->validate([
            'query' => 'required|string|min:3|max:100'
        ]);

        $searchTerm = $request->input('query');
        
        $patients = Patient::where('first_name', 'like', "%{$searchTerm}%")
            ->orWhere('last_name', 'like', "%{$searchTerm}%")
            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$searchTerm}%"])
            ->select('first_name', 'last_name', 'patient_id')
            ->orderBy('last_name')
            ->get(10);
        
        return response()->json($patients);
    }
}
