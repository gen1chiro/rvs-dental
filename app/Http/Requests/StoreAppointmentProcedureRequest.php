<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentProcedureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'procedure_id' => 'required|exists:dental_procedures,procedure_id',
            'charged_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array {
        return [
            'procedure_id.required' => 'Please select a procedure.',
            'procedure_id.exists' => 'The selected procedure is invalid.',
            'charged_price.required' => 'Charged price is required.',
            'charged_price.numeric' => 'Charged price must be a valid number.',
            'charged_price.min' => 'Charged price cannot be negative.',
        ];
    }
}
