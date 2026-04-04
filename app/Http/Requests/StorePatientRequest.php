<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class StorePatientRequest extends BasePatientRequest
{
    /**
     * Only roles with Staff or Dentist can edit patient info
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole(['Staff', 'Dentist']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:255|string',
            'last_name' => 'required|max:255|string',
            'address' => 'required|string|max:255',
            'contact_no' => 'required|regex:/^09\d{9}$/',
            'image_filename' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'date_of_birth' => 'required|before:today|date',
            'occupation' => 'required|string|max:255',
            'marital_status' => 'required|in:Single,Married,Widowed,Separated',
            'guardian_name' => 'nullable|string|max:255',
            'sex' => 'required|in:Male,Female',
        ];
    }
}
