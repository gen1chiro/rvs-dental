<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('medical_conditions')->insert([
            ['condition_name' => 'High blood pressure'],
            ['condition_name' => 'Heart disease'],
            ['condition_name' => 'Diabetes'],
            ['condition_name' => 'Tuberculosis'],
            ['condition_name' => 'Asthma'],
            ['condition_name' => 'Anemia'],
            ['condition_name' => 'Goiter'],
            ['condition_name' => 'Epilepsy / Convulsions'],
            ['condition_name' => 'Stroke'],
            ['condition_name' => 'Chest pain'],
            ['condition_name' => 'Heart surgery'],
            ['condition_name' => 'Heart attack'],
            ['condition_name' => 'Low blood pressure'],
            ['condition_name' => 'Kidney disease'],
            ['condition_name' => 'Rheumatic fever'],
            ['condition_name' => 'Hepatitis / Jaundice'],
            ['condition_name' => 'Respiratory problems'],
            ['condition_name' => 'AIDS or HIV Infection'],
            ['condition_name' => 'Sexually transmitted disease'],
            ['condition_name' => 'Stomach troubles / Ulcers'],
            ['condition_name' => 'Heart murmur'],
            ['condition_name' => 'Hepatitis / Liver disease'],
            ['condition_name' => 'Swollen ankles'],
            ['condition_name' => 'Radiation therapy'],
            ['condition_name' => 'Cancer / Tumors'],
            ['condition_name' => 'Fainting seizure'],
            ['condition_name' => 'Rapid weight loss'],
            ['condition_name' => 'Joint replacement / Implant'],
            ['condition_name' => 'Hay fever / Allergies'],
            ['condition_name' => 'Head injuries'],
            ['condition_name' => 'Arthritis / Rheumatism'],
            ['condition_name' => 'Blood disease'],
            ['condition_name' => 'Bleeding problems'],
            ['condition_name' => 'Emphysema'],
            ['condition_name' => 'Angina'],
            ['condition_name' => 'Others'],
        ]);
    }
}
