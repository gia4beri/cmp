<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Options extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('options')->insert([
            ['option_name' => 'currency_usd', 'option_value' => 1],
            ['option_name' => 'currency_eur', 'option_value' => 1],
            ['option_name' => 'portal_logo', 'option_value' => ''],
            ['option_name' => 'company_info', 'option_value' => ''],
        ]);
    }
}
