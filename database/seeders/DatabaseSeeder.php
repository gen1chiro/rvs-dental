<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class, // DO NOT REMOVE!
            /*
                Reference tables first
            */
            MedicalConditionSeeder::class,
            ProcedureSeeder::class,
            ToothNumberingSeeder::class,
            DentistSeeder::class,
            PatientSeeder::class,
            MedicalQuestionSeeder::class,
            /*
                Appointments table
            */
            AppointmentSeeder::class,
            /*
                Other tables that is connected to the appointments
            */
            AppointmentProcedureSeeder::class,
            LedgerSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
