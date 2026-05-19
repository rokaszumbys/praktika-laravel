<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Techninė įranga']);
        Category::create(['name' => 'Programinė įranga']);
        Category::create(['name' => 'Tinklas']);
        Category::create(['name' => 'Prieiga']);
        Category::create(['name' => 'Kita']);
    }
}