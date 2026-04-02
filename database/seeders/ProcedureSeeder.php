<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dental_procedures')->insert([
            [
                'name' => 'Dental Consultation',
                'min_price' => 500,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //2.
            [
                'name' => 'Dental Certificate',
                'min_price' => 300,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //3.
            [
                'name' => 'Oral Prophylaxis (Minimum)',
                'min_price' => 1000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Oral Prophylaxis (Moderate)',
                'min_price' => 1500,
                'max_price' => 2000,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Oral Prophylaxis (Heavy)',
                'min_price' => 2500,
                'max_price' => 4000,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Oral Prophylaxis (Perio Case)',
                'min_price' => 5000,
                'max_price' => null,
                'notes' => 'per quad',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //4.
            [
                'name' => 'Cleaning with Fluoride',
                'min_price' => 2500,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //5.
            [
                'name' => 'Light Cure Filling (Minimum)',
                'min_price' => 1000,
                'max_price' => null,
                'notes' => 'per cavity',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Light Cure Filling (With Ext. Bu Pit)',
                'min_price' => 2000,
                'max_price' => null,
                'notes' => 'additional 1,000 on top of charged price',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Light Cure Filling (2 Surfaces)',
                'min_price' => 2000,
                'max_price' => null,
                'notes' => 'per surface',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Light Cure Filling (Posterior)',
                'min_price' => 1500,
                'max_price' => null,
                'notes' => 'deep cavity',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Light Cure Filling (Anterior)',
                'min_price' => 2500,
                'max_price' => null,
                'notes' => 'deep cavity',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //6.
            [
                'name' => 'Tooth Extraction (Minimum)',
                'min_price' => 1200,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Tooth Extraction (Temporary - kids)',
                'min_price' => 1000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Tooth Extraction (Wisdom Tooth)',
                'min_price' => 2500,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Tooth Extraction (With Suture)',
                'min_price' => 2500,
                'max_price' => null,
                'notes' => 'additional 1,500 on top of charged price',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //7.
            [
                'name' => 'Sealant',
                'min_price' => 1000,
                'max_price' => null,
                'notes' => 'per tooth',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //8.
            [
                'name' => 'Diastema Closure (Per Side)',
                'min_price' => 1500,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Diastema Closure (Both Sides)',
                'min_price' => 3000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //9.
            [
                'name' => 'Inlay / On lays (Metal)',
                'min_price' => 5000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Inlay / On lays (Composite)',
                'min_price' => 5000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //10.
            [
                'name' => 'Dental X-ray (Periapical)',
                'min_price' => 1000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //11.
            [
                'name' => 'Jacket Crown (Temporary crown)',
                'min_price' => 500,
                'max_price' => null,
                'notes' => 'per unit',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Jacket Crown (Plastic jacket)',
                'min_price' => 5000,
                'max_price' => null,
                'notes' => 'per unit',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Jacket Crown (Porcelain jacket / Tilite)',
                'min_price' => 15000,
                'max_price' => null,
                'notes' => 'per unit',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Jacket Crown (Talladium)',
                'min_price' => 10000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Jacket Crown (All Porcelain crowns)',
                'min_price' => 15000,
                'max_price' => null,
                'notes' => 'per unit',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Jacket Crown (EMAX)',
                'min_price' => 25000,
                'max_price' => null,
                'notes' => 'per unit',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Jacket Crown (Zirconia)',
                'min_price' => 30000,
                'max_price' => null,
                'notes' => 'per unit',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //12.
            [
                'name' => 'Partial Denture (Pontic)',
                'min_price' => 1000,
                'max_price' => null,
                'notes' => 'per pontic',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Partial Denture (Acrylic base)',
                'min_price' => 3000,
                'max_price' => null,
                'notes' => 'additional 3,000 on top of charged price',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Partial Denture (Casted Base Metal)',
                'min_price' => 10000,
                'max_price' => null,
                'notes' => 'additional 10,000 on top of charged price',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Partial Denture (Valplast Unilateral)',
                'min_price' => 10000,
                'max_price' => 15000,
                'notes' => '1-2 teeth',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Partial Denture (Valplast Bilateral)',
                'min_price' => 18000,
                'max_price' => 20000,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Full Denture Plastic (Up & Down)',
                'min_price' => 25000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Full Denture Plastic (Up)',
                'min_price' => 15000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Full Denture Plastic (Down)',
                'min_price' => 15000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Full Denture Valplast (Up & Down)',
                'min_price' => 40000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Full Denture Valplast (Up)',
                'min_price' => 25000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Full Denture Valplast (Down)',
                'min_price' => 25000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //13.
            [
                'name' => 'Root Canal Treatment (Posterior / Anterior)',
                'min_price' => 8000,
                'max_price' => null,
                'notes' => 'per canal',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //14.
            [
                'name' => 'Odontectomy / Impaction',
                'min_price' => 10000,
                'max_price' => 15000,
                'notes' => 'Depends on the case',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //15.
            [
                'name' => 'Gingivictomy',
                'min_price' => 2500,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //16.
            [
                'name' => 'Cautery',
                'min_price' => 2500,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //17.
            [
                'name' => 'Whitening',
                'min_price' => 25000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //18.
            [
                'name' => 'Braces (Up and Down)',
                'min_price' => 60000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Braces (Self-Ligating)',
                'min_price' => 120000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //19.
            [
                'name' => 'Retainers (Upper or Lower)',
                'min_price' => 7000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //20.
            [
                'name' => 'ApecoEctomy',
                'min_price' => 8000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //21.
            [
                'name' => 'Veneer (Composite)',
                'min_price' => 5000,
                'max_price' => 10000,
                'notes' => 'per unit',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Veneer (Indirect)',
                'min_price' => 10000,
                'max_price' => null,
                'notes' => 'per unit',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Veneer (EMAX)',
                'min_price' => 25000,
                'max_price' => null,
                'notes' => 'per unit',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'TMJ Management (Phase 1)',
                'min_price' => 60000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Repair of Dentures (With Cast)',
                'min_price' => 2500,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Repair of Dentures (Without Cast)',
                'min_price' => 2000,
                'max_price' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Expanders',
                'min_price' => 15000,
                'max_price' => null,
                'notes' => 'per arch',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            [
                'name' => 'Mouth guards',
                'min_price' => 7000,
                'max_price' => null,
                'notes' => 'per arch',
                'created_at' => now(),
                'updated_at' => now()            
            ],
            //22.
            [
                'name' => 'Remove Braces (U/L with OP & Fluoride)',
                'min_price' => 5000,
                'max_price' => null,
                'notes' => 'Outsider needs a waiver / consent from the pervious dentist',
                'created_at' => now(),
                'updated_at' => now()            
            ],
        ]);
    }
}
