<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('medical_questions')->insert([
            ['question' => 'Are you in good health?'],
            ['question' => 'Are you under medical treatment now? If so, what is the condition being treated?'],
            ['question' => 'Have you ever had serious illness or surgical operation? If so, what illness or operation?'],
            ['question' => 'Have you ever been hospitalized? If so, when and why?'],
            ['question' => 'Are you taking any prescription/non-prescription medication? If so, please specify.'],
            ['question' => 'Do you use cigarettes/tobacco products?'],
            ['question' => 'Do you use alcohol, cocaine or any dangerous drugs?'],
            ['question' => 'Are you allergic to any of the following: Local Anesthetic (ex. Lidocaine), Penicillin Antibiotics, Sulfa drugs, Aspirin, Latex, Other?'],
            ['question' => 'Bleeding time?'],
            ['question' => 'For women only: Are you pregnant?'],
            ['question' => 'For women only: Are you nursing?'],
            ['question' => 'For women only: Are you taking birth control pills?'],
            ['question' => 'Blood type?'],
            ['question' => 'Blood pressure?'],
        ]);
    }
}
