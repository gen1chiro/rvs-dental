<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
class UpdatePatientRequest extends BasePatientRequest
{
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
            'first_name' => 'sometimes|max:255|string',
            'last_name' => 'sometimes|max:255|string',
            'address' => 'sometimes|string|max:255',
            'contact_no' => 'sometimes|regex:/^09\d{9}$/',
            'image_filename' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'date_of_birth' => 'sometimes|before:today|date',
            'occupation' => 'sometimes|string|max:255',
            'marital_status' => 'sometimes|in:Single,Married,Widowed,Separated',
            'guardian_name' => 'nullable|string|max:255',
            'sex' => 'sometimes|in:Male,Female',
        ];
    }
}
