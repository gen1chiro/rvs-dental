<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('dentists')->insert([
            [
                'first_name'      => 'Ricardo',
                'last_name'       => 'Santos',
                'license_number'  => '12345',
                'specialization'  => 'General Dentistry',
            ],
            [

                'first_name'      => 'Maria',
                'last_name'       => 'Reyes',
                'license_number'  => '23456',
                'specialization'  => 'Orthodontics',
            ],
            [
                'first_name'      => 'Jose',
                'last_name'       => 'Garcia',
                'license_number'  => '34567',
                'specialization'  => 'Pediatric Dentistry',
            ],
        ]);
    }
}
