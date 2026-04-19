<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'sometimes|integer|exists:patients,patient_id',
            'dentist_id' => 'sometimes|integer|exists:dentists,dentist_id',
            'scheduled_at' => 'sometimes|date',
            'status' => 'sometimes|string|in:Scheduled,Completed,Cancelled,No Show',
            'remarks' => 'sometimes|string|max:500'
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
