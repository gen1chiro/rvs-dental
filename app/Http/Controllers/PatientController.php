<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Show lists of patients (Paginated + Infinite Scrolling + Search Bar)
    public function index() {
        $patients = Patient::latest()->paginate(10);
        return view('pages.patients.index', compact('patients'));
    }
    // Display patient add form
    public function create() {
        return view('pages.patients.create');
    }
    // Manage form submission from patient add form
    public function store(StorePatientRequest $request) {
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
    public function show(Patient $patient) {
        return view('pages.patients.show', compact('patient'));
    }
    // Show patient edit form
    public function edit(Patient $patient) {
        return view('pages.patients.edit', compact('patient'));
    }
    // Manage patient update form
    public function update(UpdatePatientRequest $request, Patient $patient) {
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
    public function destroy(Patient $patient) {
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
            ->select('first_name', 'last_name', 'patient_id')
            ->orderBy('last_name')
            ->get(10);
        
        return response()->json($patients);
    }
}
