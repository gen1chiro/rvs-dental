<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appointments')->insert([
            [
                'patient_id'     => 1,
                'dentist_id'     => 1,
                'scheduled_at'   => '2026-01-10 09:00:00',
                'status'         => 'Completed',
                'remarks'        => 'Regular checkup, no issues found.',
                'created_at'     => '2026-01-03 10:00:00',
                'updated_at'     => '2026-01-10 11:30:00',
            ],
            [
                'patient_id'     => 2,
                'dentist_id'     => 2,
                'scheduled_at'   => '2026-01-13 10:00:00',
                'status'         => 'Completed',
                'remarks'        => 'Tooth extraction performed successfully.',
                'created_at'     => '2026-01-06 09:00:00',
                'updated_at'     => '2026-01-13 12:00:00',
            ],
            [
                'patient_id'     => 3,
                'dentist_id'     => 3,
                'scheduled_at'   => '2026-01-15 11:00:00',
                'status'         => 'Cancelled',
                'remarks'        => 'Patient called to cancel, out of town.',
                'created_at'     => '2026-01-07 08:30:00',
                'updated_at'     => '2026-01-13 14:00:00',
            ],

            [
                'patient_id'     => 4,
                'dentist_id'     => 1,
                'scheduled_at'   => '2026-01-16 13:00:00',
                'status'         => 'Completed',
                'remarks'        => 'Dental filling done on lower left molar.',
                'created_at'     => '2026-01-09 11:00:00',
                'updated_at'     => '2026-01-16 15:00:00',
            ],
            [
                'patient_id'     => 5,
                'dentist_id'     => 2,
                'scheduled_at'   => '2026-01-20 09:00:00',
                'status'         => 'No Show',
                'remarks'        => 'Patient did not show up and gave no notice.',
                'created_at'     => '2026-01-14 10:00:00',
                'updated_at'     => '2026-01-20 12:00:00',
            ],
            [
                'patient_id'     => 6,
                'dentist_id'     => 3,
                'scheduled_at'   => '2026-01-22 10:30:00',
                'status'         => 'Completed',
                'remarks'        => 'Oral prophylaxis Completed.',
                'created_at'     => '2026-01-15 09:00:00',
                'updated_at'     => '2026-01-22 12:00:00',
            ],
            [
                'patient_id'     => 7,
                'dentist_id'     => 1,
                'scheduled_at'   => '2026-01-27 14:00:00',
                'status'         => 'Cancelled',
                'remarks'        => 'Patient Cancelled due to work conflict.',
                'created_at'     => '2026-01-17 08:00:00',
                'updated_at'     => '2026-01-25 10:30:00',
            ],
            [
                'patient_id'     => 8,
                'dentist_id'     => 2,
                'scheduled_at'   => '2026-06-05 11:00:00',
                'status'         => 'Scheduled',
                'remarks'        => null,
                'created_at'     => '2026-01-19 09:00:00',
                'updated_at'     => '2026-01-19 09:00:00',
            ],
            [
                'patient_id'     => 9,
                'dentist_id'     => 3,
                'scheduled_at'   => '2026-02-03 09:00:00',
                'status'         => 'Completed',
                'remarks'        => 'Tooth whitening session Completed.',
                'created_at'     => '2026-01-27 10:00:00',
                'updated_at'     => '2026-02-03 11:30:00',
            ],
            [
                'patient_id'     => 10,
                'dentist_id'     => 1,
                'scheduled_at'   => '2026-02-06 13:00:00',
                'status'         => 'No Show',
                'remarks'        => 'Patient was unreachable before the appointment.',
                'created_at'     => '2026-01-30 08:30:00',
                'updated_at'     => '2026-02-06 16:00:00',
            ],
            [
                'patient_id'     => 11,
                'dentist_id'     => 2,
                'scheduled_at'   => '2026-02-10 10:00:00',
                'status'         => 'Completed',
                'remarks'        => 'Dental crown fitted on upper right molar.',
                'created_at'     => '2026-02-03 09:00:00',
                'updated_at'     => '2026-02-10 12:30:00',
            ],
            [
                'patient_id'     => 12,
                'dentist_id'     => 3,
                'scheduled_at'   => '2026-02-17 11:00:00',
                'status'         => 'Cancelled',
                'remarks'        => 'Patient requested to move to a later date.',
                'created_at'     => '2026-02-07 10:00:00',
                'updated_at'     => '2026-02-14 09:00:00',
            ],
            [
                'patient_id'     => 13,
                'dentist_id'     => 1,
                'scheduled_at'   => '2026-02-20 14:00:00',
                'status'         => 'Completed',
                'remarks'        => 'Fluoride treatment applied.',
                'created_at'     => '2026-02-13 08:00:00',
                'updated_at'     => '2026-02-20 15:30:00',
            ],
            [
                'patient_id'     => 14,
                'dentist_id'     => 2,
                'scheduled_at'   => '2026-06-12 09:30:00',
                'status'         => 'Scheduled',
                'remarks'        => 'Follow-up for previous treatment.',
                'created_at'     => '2026-02-18 10:00:00',
                'updated_at'     => '2026-02-18 10:00:00',
            ],
            [
                'patient_id'     => 15,
                'dentist_id'     => 3,
                'scheduled_at'   => '2026-03-05 10:00:00',
                'status'         => 'Completed',
                'remarks'        => 'Dental X-ray taken, mild cavity detected.',
                'created_at'     => '2026-02-26 09:00:00',
                'updated_at'     => '2026-03-05 12:00:00',
            ],
            [
                'patient_id'     => 16,
                'dentist_id'     => 1,
                'scheduled_at'   => '2026-03-12 13:00:00',
                'status'         => 'Cancelled',
                'remarks'        => 'Patient feeling unwell, rescheduled.',
                'created_at'     => '2026-03-04 08:00:00',
                'updated_at'     => '2026-03-10 11:00:00',
            ],
            [
                'patient_id'     => 17,
                'dentist_id'     => 2,
                'scheduled_at'   => '2026-03-18 09:00:00',
                'status'         => 'Completed',
                'remarks'        => 'Pit and fissure sealant applied on molars.',
                'created_at'     => '2026-03-11 10:00:00',
                'updated_at'     => '2026-03-18 11:00:00',
            ],
            [
                'patient_id'     => 18,
                'dentist_id'     => 3,
                'scheduled_at'   => '2026-03-24 14:00:00',
                'status'         => 'No Show',
                'remarks'        => 'Patient missed the appointment without explanation.',
                'created_at'     => '2026-03-17 09:30:00',
                'updated_at'     => '2026-03-24 17:00:00',
            ],
            [
                'patient_id'     => 19,
                'dentist_id'     => 1,
                'scheduled_at'   => '2026-04-02 10:00:00',
                'status'         => 'Completed',
                'remarks'        => 'Root canal treatment Completed.',
                'created_at'     => '2026-03-26 08:00:00',
                'updated_at'     => '2026-04-02 13:00:00',
            ],
            [
                'patient_id'     => 20,
                'dentist_id'     => 2,
                'scheduled_at'   => '2026-06-20 15:00:00',
                'status'         => 'Scheduled',
                'remarks'        => null,
                'created_at'     => '2026-03-27 09:00:00',
                'updated_at'     => '2026-03-27 09:00:00',
            ],
        ]);
    }
}
