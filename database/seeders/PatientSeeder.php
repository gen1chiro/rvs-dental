<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facade\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* 

            NEED TO CREATE A MIGRATION

        */
        DB::table(/*table*/)->insert([
            [
                'patient_id'     => 1,
                'first_name'     => 'Juan',
                'last_name'      => 'Dela Cruz',
                'date_of_birth'  => '1990-01-15',
                'sex'            => 'Male',
                'address'        => 'Malolos, Bulacan',
                'occupation'     => 'Teacher',
                'telephone'      => '09171234567',
                'marital_status' => 'Single',
                'guardian_name'  => NULL,
            ],
            [
                'patient_id'     => 2,
                'first_name'     => 'Maria',
                'last_name'      => 'Santos',
                'date_of_birth'  => '1985-06-20',
                'sex'            => 'Female',
                'address'        => 'Meycauayan, Bulacan',
                'occupation'     => 'Nurse',
                'telephone'      => '09181234567',
                'marital_status' => 'Married',
                'guardian_name'  => NULL,
            ],
            [
                'patient_id'     => 3,
                'first_name'     => 'Jose',
                'last_name'      => 'Reyes',
                'date_of_birth'  => '2015-03-10',
                'sex'            => 'Male',
                'address'        => 'Marilao, Bulacan',
                'occupation'     => 'Student',
                'telephone'      => '09191234567',
                'marital_status' => 'Single',
                'guardian_name'  => 'Ana Reyes',
            ],
        ]);
        
    }
}
