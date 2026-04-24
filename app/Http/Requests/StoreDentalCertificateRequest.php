<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDentalCertificateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
                'appointment_id' => 'required|integer',
                'recommendation' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
                'appointment_id.required' => 'The patient has no scheduled appointment.',
                'recommendation.required' => 'Please enter a recommendation before printing.',
        ];
    }
}
