<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->delete();
        $categories= [
            [
                'name' => 'Electronic',
            ],
            [
                'name' => 'Man',
            ],
            [
                'name' => 'Woman',
            ],
            [
                'name' => 'Phone',
                'parent_id' => 1,
            ],
            [
                'name' => 'IOS Mobile Phone',
                'parent_id' => 4,
            ],
            [
                'name' => 'Clothes',
                'parent_id' => 2,
            ],
            [
                'name' => 'Cosmetic',
                'parent_id' => 3,
            ],
        ];
        foreach ($categories as $category) {
            DB::table('categories')->insert($category);
        }
    }
}
