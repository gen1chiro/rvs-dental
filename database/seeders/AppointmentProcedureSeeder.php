<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appointment_procedures')->insert([
            /*

                Ang mga completed is appointment_id 1, 2, 4, 6, 9, 11, 13, 15, 17, 19
                The same creation time in appointment_procedures, ledger, transactions

             */
            [
                'appointment_id'           => 1,
                'procedure_id'             => 1,  
                'notes'                    => null,
                'charged_price'            => 500.00,
                'created_at'               => '2026-01-10 09:15:00',
                'updated_at'               => '2026-01-10 09:15:00',
            ],
            [
                'appointment_id'           => 1,
                'procedure_id'             => 3, 
                'notes'                    => 'Full mouth cleaning done.',
                'charged_price'            => 1000.00,
                'created_at'               => '2026-01-10 09:30:00',
                'updated_at'               => '2026-01-10 09:30:00',
            ],
            [
                'appointment_id'           => 2,
                'procedure_id'             => 22, 
                'notes'                    => 'Periapical X-ray taken prior to extraction.',
                'charged_price'            => 1000.00,
                'created_at'               => '2026-01-13 10:10:00',
                'updated_at'               => '2026-01-13 10:10:00',
            ],
            [
                'appointment_id'           => 2,
                'procedure_id'             => 13, 
                'notes'                    => 'Lower right first molar extracted.',
                'charged_price'            => 1200.00,
                'created_at'               => '2026-01-13 10:30:00',
                'updated_at'               => '2026-01-13 10:30:00',
            ],
            [
                'appointment_id'           => 4,
                'procedure_id'             => 8, 
                'notes'                    => 'Light cure filling on lower left molar.',
                'charged_price'            => 1000.00,
                'created_at'               => '2026-01-16 13:30:00',
                'updated_at'               => '2026-01-16 13:30:00',
            ],
            [
                'appointment_id'           => 6,
                'procedure_id'             => 4,  
                'notes'                    => null,
                'charged_price'            => 1500.00,
                'created_at'               => '2026-01-22 10:45:00',
                'updated_at'               => '2026-01-22 10:45:00',
            ],
            [
                'appointment_id'           => 6,
                'procedure_id'             => 7,  
                'notes'                    => 'Applied after prophylaxis.',
                'charged_price'            => 2500.00,
                'created_at'               => '2026-01-22 11:00:00',
                'updated_at'               => '2026-01-22 11:00:00',
            ],
            [
                'appointment_id'           => 9,
                'procedure_id'             => 45,
                'notes'                    => 'In-clinic whitening session.',
                'charged_price'            => 25000.00,
                'created_at'               => '2026-02-03 09:30:00',
                'updated_at'               => '2026-02-03 09:30:00',
            ],
            [
                'appointment_id'           => 11,
                'procedure_id'             => 22, 
                'notes'                    => 'Pre-crown X-ray.',
                'charged_price'            => 1000.00,
                'created_at'               => '2026-02-10 10:15:00',
                'updated_at'               => '2026-02-10 10:15:00',
            ],
            [
                'appointment_id'           => 11,
                'procedure_id'             => 25,
                'notes'                    => 'Porcelain crown fitted on upper right molar.',
                'charged_price'            => 15000.00,
                'created_at'               => '2026-02-10 10:30:00',
                'updated_at'               => '2026-02-10 10:30:00',
            ],
            [
                'appointment_id'           => 13,
                'procedure_id'             => 1,  
                'notes'                    => null,
                'charged_price'            => 500.00,
                'created_at'               => '2026-02-20 14:00:00',
                'updated_at'               => '2026-02-20 14:00:00',
            ],
            [
                'appointment_id'           => 13,
                'procedure_id'             => 3,  
                'notes'                    => null,
                'charged_price'            => 1000.00,
                'created_at'               => '2026-02-20 14:30:00',
                'updated_at'               => '2026-02-20 14:30:00',
            ],
            [
                'appointment_id'           => 15,
                'procedure_id'             => 22, 
                'notes'                    => 'Panoramic X-ray, mild cavity detected on upper left.',
                'charged_price'            => 1000.00,
                'created_at'               => '2026-03-05 10:15:00',
                'updated_at'               => '2026-03-05 10:15:00',
            ],
            [
                'appointment_id'           => 15,
                'procedure_id'             => 8,  
                'notes'                    => 'Small filling on upper left premolar.',
                'charged_price'            => 1000.00,
                'created_at'               => '2026-03-05 10:45:00',
                'updated_at'               => '2026-03-05 10:45:00',
            ],
            [
                'appointment_id'           => 17,
                'procedure_id'             => 17,
                'notes'                    => 'Applied on all four molars.',
                'charged_price'            => 1000.00,
                'created_at'               => '2026-03-18 09:30:00',
                'updated_at'               => '2026-03-18 09:30:00',
            ],
            [
                'appointment_id'           => 19,
                'procedure_id'             => 22, 
                'notes'                    => 'Pre root canal X-ray.',
                'charged_price'            => 1000.00,
                'created_at'               => '2026-04-02 10:15:00',
                'updated_at'               => '2026-04-02 10:15:00',
            ],
            [
                'appointment_id'           => 19,
                'procedure_id'             => 41, 
                'notes'                    => 'Single canal, lower left molar.',
                'charged_price'            => 8000.00,
                'created_at'               => '2026-04-02 10:30:00',
                'updated_at'               => '2026-04-02 10:30:00',
            ],
 
        ]);
    }
}
