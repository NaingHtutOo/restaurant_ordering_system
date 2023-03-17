<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'japanese',
            'created_at' => Now(),
            'updated_at' => Now(),
        ]);
        DB::table('categories')->insert([
            'name' => 'chinese',
            'created_at' => Now(),
            'updated_at' => Now(),
        ]);
        DB::table('categories')->insert([
            'name' => 'drink',
            'created_at' => Now(),
            'updated_at' => Now(),
        ]);
    }
}
