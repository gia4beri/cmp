<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            "username" => "admin",
            "password" => Hash::make("zoo9iekieh1Eephi"),
            "first_name" => "მთავარი",
            "last_name" => "ადმინისტრატორი",
            "role" => "admin",
        ]);
    }
}
