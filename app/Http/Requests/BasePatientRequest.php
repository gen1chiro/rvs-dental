<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

abstract class BasePatientRequest extends FormRequest {
    public function messages(): array {
        return [
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'sex.in' => 'Sex must be either Male or Female only.',
            'marital_status.in' => 'Invalid marital status.',
            'image_filename.mimes' => 'Image must be of the following formats only: .JPEG, .JPG, .PNG.',
            'contact_no.regex' => 'Contact number must be a valid Philippine mobile number (e.g., 09123456789).'
        ];
    }
}