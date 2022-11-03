<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                Permessions::class,
                UserSeeder::class,
                CategorySeeder::class,
                ProductSeeder::class,
            ],
        );
        Artisan::call('passport:install');
    }
}
