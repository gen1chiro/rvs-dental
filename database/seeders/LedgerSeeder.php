<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ledger')->insert([
            [
                'appointment_procedure_id' => 1,
                'description'              => 'Charge for Dental Consultation — Appointment #1',
                'created_at'               => '2026-01-10 09:15:00',
                'updated_at'               => '2026-01-10 09:15:00',
            ],
            [
                'appointment_procedure_id' => 2,
                'description'              => 'Charge for Oral Prophylaxis (Minimum) — Appointment #1',
                'created_at'               => '2026-01-10 09:30:00',
                'updated_at'               => '2026-01-10 09:30:00',
            ],
            [
                'appointment_procedure_id' => 3,
                'description'              => 'Charge for Dental X-ray (Periapical) — Appointment #2',
                'created_at'               => '2026-01-13 10:10:00',
                'updated_at'               => '2026-01-13 10:10:00',
            ],
            [
                'appointment_procedure_id' => 4,
                'description'              => 'Charge for Tooth Extraction (Minimum) — Appointment #2',
                'created_at'               => '2026-01-13 10:30:00',
                'updated_at'               => '2026-01-13 10:30:00',
            ],
            [
                'appointment_procedure_id' => 5,
                'description'              => 'Charge for Light Cure Filling (Minimum) — Appointment #4',
                'created_at'               => '2026-01-16 13:30:00',
                'updated_at'               => '2026-01-16 13:30:00',
            ],
            [
                'appointment_procedure_id' => 6,
                'description'              => 'Charge for Oral Prophylaxis (Moderate) — Appointment #6',
                'created_at'               => '2026-01-22 10:45:00',
                'updated_at'               => '2026-01-22 10:45:00',
            ],
            [
                'appointment_procedure_id' => 7,
                'description'              => 'Charge for Cleaning with Fluoride — Appointment #6',
                'created_at'               => '2026-01-22 11:00:00',
                'updated_at'               => '2026-01-22 11:00:00',
            ],
            [
                'appointment_procedure_id' => 8,
                'description'              => 'Charge for Whitening — Appointment #9',
                'created_at'               => '2026-02-03 09:30:00',
                'updated_at'               => '2026-02-03 09:30:00',
            ],
            [
                'appointment_procedure_id' => 9,
                'description'              => 'Charge for Dental X-ray (Periapical) — Appointment #11',
                'created_at'               => '2026-02-10 10:15:00',
                'updated_at'               => '2026-02-10 10:15:00',
            ],
            [
                'appointment_procedure_id' => 10,
                'description'              => 'Charge for Jacket Crown (Porcelain jacket / Tilite) — Appointment #11',
                'created_at'               => '2026-02-10 10:30:00',
                'updated_at'               => '2026-02-10 10:30:00',
            ],
            [
                'appointment_procedure_id' => 11,
                'description'              => 'Charge for Dental Consultation — Appointment #13',
                'created_at'               => '2026-02-20 14:00:00',
                'updated_at'               => '2026-02-20 14:00:00',
            ],
            [
                'appointment_procedure_id' => 12,
                'description'              => 'Charge for Oral Prophylaxis (Minimum) — Appointment #13',
                'created_at'               => '2026-02-20 14:30:00',
                'updated_at'               => '2026-02-20 14:30:00',
            ],
            [
                'appointment_procedure_id' => 13,
                'description'              => 'Charge for Dental X-ray (Periapical) — Appointment #15',
                'created_at'               => '2026-03-05 10:15:00',
                'updated_at'               => '2026-03-05 10:15:00',
            ],
            [
                'appointment_procedure_id' => 14,
                'description'              => 'Charge for Light Cure Filling (Minimum) — Appointment #15',
                'created_at'               => '2026-03-05 10:45:00',
                'updated_at'               => '2026-03-05 10:45:00',
            ],
            [
                'appointment_procedure_id' => 15,
                'description'              => 'Charge for Sealant — Appointment #17',
                'created_at'               => '2026-03-18 09:30:00',
                'updated_at'               => '2026-03-18 09:30:00',
            ],
            [
                'appointment_procedure_id' => 16,
                'description'              => 'Charge for Dental X-ray (Periapical) — Appointment #19',
                'created_at'               => '2026-04-02 10:15:00',
                'updated_at'               => '2026-04-02 10:15:00',
            ],
            [
                'appointment_procedure_id' => 17,
                'description'              => 'Charge for Root Canal Treatment (Posterior / Anterior) — Appointment #19',
                'created_at'               => '2026-04-02 10:30:00',
                'updated_at'               => '2026-04-02 10:30:00',
            ],
 
        ]);
    }
}
