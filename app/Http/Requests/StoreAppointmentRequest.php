<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|integer|exists:patients,patient_id',
            'dentist_id' => 'required|integer|exists:dentists,dentist_id',
            'slot' => 'required|in:Morning,Afternoon',
            'scheduled_at' => 'required|date|after:now',
            'status' => 'nullable|string|in:Scheduled,Completed,Cancelled,No Show',
            'remarks' => 'nullable|string|max:500'
        ];
    }
    public function messages(): array
    {
        return [
            'dentist_id.required'   => 'Please assign a dentist.',
            'dentist_id.exists'     => 'The selected dentist does not exist.',
            'scheduled_at.required' => 'Please enter a schedule slot.',
            'slot.in'               => 'Invalid slot selection.',
            'scheduled_at.after'    => 'The schedule must be a future date and time.',
            'status.in'             => 'Invalid status selection.',
            'remarks.max'           => 'Remarks must not exceed 500 characters.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->filled('status')) {
            $this->merge(['status' => 'Scheduled']);
        }
    }
}
