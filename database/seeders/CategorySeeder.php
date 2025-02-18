<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Adventure']);
        Category::create(['name' => 'Relaxation']);
        Category::create(['name' => 'Cultural']);
    }
}


