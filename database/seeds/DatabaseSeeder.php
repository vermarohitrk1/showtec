<?php

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\LeadStatusSeeder;
use Database\Seeders\SettingSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        $this->call(UserSeeder::class);
        $this->call(LeadStatusSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
