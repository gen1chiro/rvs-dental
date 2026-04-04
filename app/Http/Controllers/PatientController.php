<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;

class PatientController extends Controller
{
    // Show lists of patients (Paginated + Infinite Scrolling + Search Bar)
    public function index() {
        $patients = Patient::paginate(5);
        return view('pages.patients.test', compact('patients'));
    }
    // Display patient add form
    public function create() {
        return view('pages.patients.create');
    }
    // Manage form submission from patient add form
    public function store(StorePatientRequest $request) {}
    // Display a specific patient information
    public function show(Patient $patient) {
        return view('pages.patients.show', compact('patient'));
    }
    // Show patient edit form
    public function edit(Patient $patient) {
        return view('pages.patients.edit', compact('patient'));
    }
    // Manage patient update form
    public function update(UpdatePatientRequest $request, Patient $patient) {}
    // Delete a specific patient (soft-deletes only)
    public function destroy(Patient $patient) {}
}