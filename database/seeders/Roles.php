<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("roles")->insert([
            ["slug" => "admin", "description" => "ადმინისტრატორი"],
            ["slug" => "reception", "description" => "მიმღები"],
            ["slug" => "doctor", "description" => "ექიმი"],
            ["slug" => "user", "description" => "მომხმარებელი"],
        ]);
    }
}
