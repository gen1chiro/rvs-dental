<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'patient_id' => 'required|integer|exists:patient,patient_id',
            'dentist_id' => 'required|integer|exists:dentist,dentist_id',
            'scheduled_at' => 'required|date|after:now',
            'status' => 'required|string|in:Scheduled,Complete,Cancelled,No Show',
            'remarks' => 'required|string|max:500'
        ];
    }
    public function messages(): array
    {
        return [
            'dentist_id.required'   => 'Please assign a dentist.',
            'dentist_id.exists'     => 'The selected dentist does not exist.',
            'scheduled_at.required' => 'Please enter a schedule slot.',
            'scheduled_at.after'    => 'The schedule must be a future date and time.',
            'status.required'       => 'Please select a status.',
            'status.in'             => 'The selected status is invalid.',
            'remarks.max'           => 'Remarks must not exceed 500 characters.',
        ];
    }
}
