<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guide;

class GuideSeeder extends Seeder
{
    public function run()
    {
        Guide::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'languages' => 'English, Spanish',
            'email' => 'john.doe@examble.com',
            'phone' => '123456789'
        ]);

        Guide::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'languages' => 'French, German',
            'email' => 'jane.smith@examle.com',
            'phone' => '987654321'
        ]);
    }
}
