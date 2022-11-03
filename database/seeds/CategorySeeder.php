<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            Category::create([
                'name' => $faker->name,
                'gambar' => $faker->image('public/assets/images/category', 50, 50, 'cats', true),
            ]);
        }
    }
}
