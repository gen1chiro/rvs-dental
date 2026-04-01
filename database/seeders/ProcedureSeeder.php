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
        /* 

            NEED TO CREATE A MIGRATION

        */
        DB::table('dental_procedures')->insert([
            //1.
            [
                'name' => 'Dental Consultation',
                'min_price' => 500,
                'notes' => null
            ],
            //2.
            [
                'name' => 'Dental Certificate',
                'min_price' => 300,
                'notes' => null
            ],
            //3.
            [
                'name' => 'Oral Prophylaxis (Minimum)',
                'min_price' => 1000,
                'notes' => null
            ],
            [
                'name' => 'Oral Prophylaxis (Moderate)',
                'min_price' => 1500,
                'notes' => null
            ],
            [
                'name' => 'Oral Prophylaxis (Heavy)',
                'min_price' => 2500,
                'notes' => null
            ],
            [
                'name' => 'Oral Prophylaxis (Perio Case)',
                'min_price' => 5000,
                'notes' => 'per quad'
            ],
            //4.
            [
                'name' => 'Cleaning with Fluoride',
                'min_price' => 2500,
                'notes' => null
            ],
            //5.
            [
                'name' => 'Light Cure Filling (Minimum)',
                'min_price' => 1000,
                'notes' => 'per cavity'
            ],
            [
                'name' => 'Light Cure Filling (With Ext. Bu Pit)',
                'min_price' => 2000,
                'notes' => 'additional 1,000 on top of base price'
            ],
            [
                'name' => 'Light Cure Filling (2 Surfaces)',
                'min_price' => 2000,
                'notes' => 'per surface'
            ],
            [
                'name' => 'Light Cure Filling (Posterior)',
                'min_price' => 1500,
                'notes' => 'deep cavity'
            ],
            [
                'name' => 'Light Cure Filling (Anterior)',
                'min_price' => 2500,
                'notes' => 'deep cavity'
            ],
            //6.
            [
                'name' => 'Tooth Extraction (Minimum)',
                'min_price' => 1200,
                'notes' => null
            ],
            [
                'name' => 'Tooth Extraction (Temporary - kids)',
                'min_price' => 1000,
                'notes' => null
            ],
            [
                'name' => 'Tooth Extraction (Wisdom Tooth)',
                'min_price' => 2500,
                'notes' => null
            ],
            [
                'name' => 'Tooth Extraction (With Suture)',
                'min_price' => 2500,
                'notes' => 'additional 1,500 on top of base price'
            ],
            //7.
            [
                'name' => 'Sealant',
                'min_price' => 1000,
                'notes' => 'per tooth'
            ],
            //8.
            [
                'name' => 'Diastema Closure (Per Side)',
                'min_price' => 1500,
                'notes' => null
            ],
            [
                'name' => 'Diastema Closure (Both Sides)',
                'min_price' => 3000,
                'notes' => null
            ],
            //9.
            [
                'name' => 'Inlay / On lays (Metal)',
                'min_price' => 5000,
                'notes' => null
            ],
            [
                'name' => 'Inlay / On lays (Composite)',
                'min_price' => 5000,
                'notes' => null
            ],
            //10.
            [
                'name' => 'Dental X-ray (Periapical)',
                'min_price' => 1000,
                'notes' => null
            ],
            //11.
            [
                'name' => 'Jacket Crown (Temporary crown)',
                'min_price' => 500,
                'notes' => 'per unit'
            ],
            [
                'name' => 'Jacket Crown (Plastic jacket)',
                'min_price' => 5000,
                'notes' => 'per unit'
            ],
            [
                'name' => 'Jacket Crown (Porcelain jacket / Tilite)',
                'min_price' => 15000,
                'notes' => 'per unit'
            ],
            [
                'name' => 'Jacket Crown (Talladium)',
                'min_price' => 10000,
                'notes' => null
            ],
            [
                'name' => 'Jacket Crown (All Porcelain crowns)',
                'min_price' => 15000,
                'notes' => 'per unit'
            ],
            [
                'name' => 'Jacket Crown (EMAX)',
                'min_price' => 25000,
                'notes' => 'per unit'
            ],
            [
                'name' => 'Jacket Crown (Zirconia)',
                'min_price' => 30000,
                'notes' => 'per unit'
            ],
            //12.
            [
                'name' => 'Partial Denture (Pontic)',
                'min_price' => 1000,
                'notes' => 'per pontic'
            ],
            [
                'name' => 'Partial Denture (Acrylic base)',
                'min_price' => 3000,
                'notes' => 'additional 3,000 on top of base price'
            ],
            [
                'name' => 'Partial Denture (Casted Base Metal)',
                'min_price' => 10000,
                'notes' => 'additional 10,000 on top of base price'
            ],
            [
                'name' => 'Partial Denture (Valplast Unilateral)',
                'min_price' => 10000,
                'notes' => '1-2 teeth'
            ],
            [
                'name' => 'Partial Denture (Valplast Bilateral)',
                'min_price' => 18000,
                'notes' => null
            ],
            [
                'name' => 'Full Denture Plastic (Up & Down)',
                'min_price' => 25000,
                'notes' => null
            ],
            [
                'name' => 'Full Denture Plastic (Up)',
                'min_price' => 15000,
                'notes' => null
            ],
            [
                'name' => 'Full Denture Plastic (Down)',
                'min_price' => 15000,
                'notes' => null
            ],
            [
                'name' => 'Full Denture Valplast (Up & Down)',
                'min_price' => 40000,
                'notes' => null
            ],
            [
                'name' => 'Full Denture Valplast (Up)',
                'min_price' => 25000,
                'notes' => null
            ],
            [
                'name' => 'Full Denture Valplast (Down)',
                'min_price' => 25000,
                'notes' => null
            ],
            //13.
            [
                'name' => 'Root Canal Treatment (Posterior / Anterior)',
                'min_price' => 8000,
                'notes' => 'per canal'
            ],
            //14.
            [
                'name' => 'Odontectomy / Impaction',
                'min_price' => 10000,
                'notes' => 'Depends on the case'
            ],
            //15.
            [
                'name' => 'Gingivictomy',
                'min_price' => 2500,
                'notes' => null
            ],
            //16.
            [
                'name' => 'Cautery',
                'min_price' => 2500,
                'notes' => null
            ],
            //17.
            [
                'name' => 'Whitening',
                'min_price' => 25000,
                'notes' => null
            ],
            //18.
            [
                'name' => 'Braces (Up and Down)',
                'min_price' => 60000,
                'notes' => null
            ],
            [
                'name' => 'Braces (Self-Ligating)',
                'min_price' => 120000,
                'notes' => null
            ],
            //19.
            [
                'name' => 'Retainers (Upper or Lower)',
                'min_price' => 7000,
                'notes' => null
            ],
            //20.
            [
                'name' => 'ApecoEctomy',
                'min_price' => 8000,
                'notes' => null
            ],
            //21.
            [
                'name' => 'Veneer (Composite)',
                'min_price' => 5000,
                'notes' => 'per unit'
            ],
            [
                'name' => 'Veneer (Indirect)',
                'min_price' => 10000,
                'notes' => 'per unit'
            ],
            [
                'name' => 'Veneer (EMAX)',
                'min_price' => 25000,
                'notes' => 'per unit'
            ],
            [
                'name' => 'TMJ Management (Phase 1)',
                'min_price' => 60000,
                'notes' => null
            ],
            [
                'name' => 'Repair of Dentures (With Cast)',
                'min_price' => 2500,
                'notes' => null
            ],
            [
                'name' => 'Repair of Dentures (Without Cast)',
                'min_price' => 2000,
                'notes' => null
            ],
            [
                'name' => 'Expanders',
                'min_price' => 15000,
                'notes' => 'per arch'
            ],
            [
                'name' => 'Mouth guards',
                'min_price' => 7000,
                'notes' => 'per arch'
            ],
            //22.
            [
                'name' => 'Remove Braces (U/L with OP & Fluoride)',
                'min_price' => 5000,
                'notes' => 'Outsider needs a waiver / consent from the pervious dentist'
            ],
        ]);
    }
}
