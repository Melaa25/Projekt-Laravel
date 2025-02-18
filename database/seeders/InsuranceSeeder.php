<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Insurance;

class InsuranceSeeder extends Seeder
{
    public function run()
    {
        Insurance::create(['name' => 'Basic Insurance', 'description' => 'Covers basic risks.', 'price' => 50.00]);
        Insurance::create(['name' => 'Premium Insurance', 'description' => 'Includes additional benefits.', 'price' => 150.00]);
        Insurance::create(['name' => 'Family Insurance', 'description' => 'Designed for families.', 'price' => 200.00]);
    }
}

