<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PercentageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('percentage_types')->insert([
            [
                'name'       => 'agent',
                'type'       => 'Percentage',
                'value'      => 5,
            ],
            [
                'name'       => 'farmer',
                'type'       => 'Percentage',
                'value'      => 95,
            ],
        ]);
    }
}
