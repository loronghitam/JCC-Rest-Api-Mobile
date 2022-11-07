<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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
            Product::create([
                'nama' => $faker->name(),
                'tahun_pembuatan' => $faker->year(),
                'category_id' => random_int(1, 10),
                'user_id' => random_int(1, 32),
                'tahun_pembuatan' => $faker->year('now'),
            ])->ProductDetails()->create([
                'status' => $faker->randomElement((['belum ada', 'ada'])),
                'deskripsi' => $faker->text(50),
                'harga' => $faker->randomFloat(),
                'dimensi' => $faker->randomElement((['5x5x5', '10x10x10'])),
                'media' => $faker->randomElement((['canvas', 'carton'])),
                'status_barang' => $faker->randomElement((['baru', 'jelek', 'bagus'])),
                'kondisi' => $faker->randomElement((['baru kemari', 'tadi loh'])),
                'gambar' => $faker->imageUrl(224, 431, 'cats')

            ]);
        }
    }
}
