<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToothNumberingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
            Based on Oral Examination Card 
            Adult Teeth (32 Total) permanent
            Children Teeth (20 Total) temporary
        */
        $quadrants = [
            1 => 'Upper Right',
            2 => 'Upper Left',
            3 => 'Lower Left',
            4 => 'Lower Right',
            5 => 'Upper Right',
            6 => 'Upper Left',
            7 => 'Lower Left',
            8 => 'Lower Right',
        ];

        $teeth = [];

        foreach (range(1, 4) as $quadrant) {
            foreach (range(1, 8) as $position) {
                $teeth[] = [
                    'tooth_id'   => ($quadrant * 10) + $position,
                    'type'       => 'permanent',
                    'quadrant'   => $quadrants[$quadrant],
                    'position'   => $position,
                ];
            }
        }

        foreach (range(5, 8) as $quadrant) {
            foreach (range(1, 5) as $position) {
                $teeth[] = [
                    'tooth_id'   => ($quadrant * 10) + $position,
                    'type'       => 'temporary',
                    'quadrant'   => $quadrants[$quadrant],
                    'position'   => $position,
                ];
            }
        }
        /* 

            NEED TO CREATE A MIGRATION

        */
        DB::table(/*table*/)->insert($teeth);
    }
}
