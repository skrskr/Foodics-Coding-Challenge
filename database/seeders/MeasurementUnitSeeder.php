<?php

namespace Database\Seeders;

use App\Models\MeasurementUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeasurementUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeasurementUnit::create([
            'name' => "Gram",
            'abbreviation' => "g",
            'rate' => 1.0
        ]);

        MeasurementUnit::create([
            'name' => "KiloGram",
            'abbreviation' => "kg",
            'rate' => 1000
        ]);
    }
}
