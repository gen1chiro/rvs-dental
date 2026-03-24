<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Users')->insert([
            [
                'name' => 'John Octavio', 
                'password' => 'admin123', 
                'email' => 'jo.admin@sample.dev', 
                'role' => 'Dentist'
            ],
            [
                'name' => 'Toby Javelona', 
                'password' => 'admin123', 
                'email' => 'tj.admin@sample.dev', 
                'role' => 'Staff'
            ],
            [
                'name' => 'Raean Tamayo', 
                'password' => 'patient123', 
                'email' => 'rt.patient@sample.dev', 
                'role' => 'Patient'
            ],
        ]);
    }
}
