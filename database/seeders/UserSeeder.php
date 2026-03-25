<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'password' => Hash::make('admin123'), 
                'email' => 'jo.admin@sample.dev', 
                'role' => 'Dentist',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toby Javelona', 
                'password' => Hash::make('admin123'), 
                'email' => 'tj.admin@sample.dev', 
                'role' => 'Staff',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Raean Tamayo', 
                'password' => Hash::make('patient123'), 
                'email' => 'rt.patient@sample.dev', 
                'role' => 'Patient',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
