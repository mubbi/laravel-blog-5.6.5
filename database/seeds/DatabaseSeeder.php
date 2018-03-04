<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        $this->call(
            UsersTableSeeder::class,
            SettingsTableSeeder::class
            // CategoriesTableSeeder::class,
            // BlogsTableSeeder::class,
        );
        // Model::reguard();
    }
}
