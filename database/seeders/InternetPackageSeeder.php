<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternetPackage;

class InternetPackageSeeder extends Seeder
{
    public function run()
    {
        InternetPackage::create(['name' => 'Basic Package', 'data_limit' => '10GB', 'price' => 20.00]);
        InternetPackage::create(['name' => 'Unlimited Package', 'data_limit' => 'Unlimited', 'price' => 50.00]);
        InternetPackage::create(['name' => 'Family Package', 'data_limit' => '50GB', 'price' => 35.00]);
    }
}
