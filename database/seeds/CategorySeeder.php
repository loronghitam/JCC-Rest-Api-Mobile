<?php

use App\Category;
use Faker\Factory;
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
        $faker = Factory::create();
        $category = ['painting', 'sculpture', 'drawing', 'prints', 'installation', 'collage', 'mixed media', 'illustration', 'realism', 'faux naif', 'surrealisme', 'symbolism'];
        for ($i = 0; $i < 10; $i++) {
            Category::create([
                'name' => $faker->unique()->randomElement($category),
                'gambar' => $faker->imageUrl(499, 257, 'cats')
            ]);
        }
    }
}
