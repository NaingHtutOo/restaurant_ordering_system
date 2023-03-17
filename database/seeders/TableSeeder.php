<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for( $i = 1; $i <= 5; $i++ ) {
            DB::table('tables')->insert([
                'name' => '0' . $i,
                'status' => 1,
                'total' => 0,
                'created_at' => Now(),
                'updated_at' => Now(),
            ]);
        }
    }
}
