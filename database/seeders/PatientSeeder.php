<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('patients')->insert([
            [
                'first_name'     => 'Juan',
                'last_name'      => 'Dela Cruz',
                'date_of_birth'  => '1990-01-15',
                'sex'            => 'Male',
                'address'        => 'Malolos, Bulacan',
                'occupation'     => 'Teacher',
                'contact_number' => '09171234567',
                'marital_status' => 'Single',
                'guardian_name'  => NULL,
            ],
            [
                'first_name'     => 'Maria',
                'last_name'      => 'Santos',
                'date_of_birth'  => '1985-06-20',
                'sex'            => 'Female',
                'address'        => 'Meycauayan, Bulacan',
                'occupation'     => 'Nurse',
                'contact_number' => '09181234567',
                'marital_status' => 'Married',
                'guardian_name'  => NULL,
            ],
            [
                'first_name'     => 'Jose',
                'last_name'      => 'Reyes',
                'date_of_birth'  => '2015-03-10',
                'sex'            => 'Male',
                'address'        => 'Marilao, Bulacan',
                'occupation'     => 'Student',
                'contact_number' => '09191234567',
                'marital_status' => 'Single',
                'guardian_name'  => 'Ana Reyes',
            ],
        ]);
        
    }
}
