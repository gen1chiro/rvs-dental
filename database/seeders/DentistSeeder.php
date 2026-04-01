<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facade\DB;

class DentistSeeder extends Seeder
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
                'dentist_id'      => 1,
                'first_name'      => 'Ricardo',
                'last_name'       => 'Santos',
                'license_number'  => 12345,
                'specialization'  => 'General Dentistry',
            ],
            [
                'dentist_id'      => 2,
                'first_name'      => 'Maria',
                'last_name'       => 'Reyes',
                'license_number'  => 23456,
                'specialization'  => 'Orthodontics',
            ],
            [
                'dentist_id'      => 3,
                'first_name'      => 'Jose',
                'last_name'       => 'Garcia',
                'license_number'  => 34567,
                'specialization'  => 'Pediatric Dentistry',
            ],
        ]);
    }
}
