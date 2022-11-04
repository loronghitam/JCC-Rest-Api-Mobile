<?php

use App\User;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => bcrypt('password'),
            'role' => 'collector',
        ])->assignRole('collector')->userDetail()->create([
            'tanggal_lahir' => $faker->date('Y-m-d', 'now'),
            'tempat_lahir' => $faker->city(),
            'biografi' => $faker->text(40),
            'status' => $faker->word(),
            'no_phone' => $faker->e164PhoneNumber,
            'aliran' => $faker->word(),
            'gambar' => $faker->image(base_path('public/assets/images/user/'))
        ])->address()->create([
            'no_alamat' => $faker->randomNumber(5),
            'alamat' => $faker->cityPrefix,
            'provinsi' => $faker->state,
            'kecamatan' => $faker->citySuffix(),
            'kota' => $faker->city(),
            'desa' => $faker->streetName(),
            'prioritas' => $faker->randomNumber('1',),
        ]);
        User::create([
            'name' => 'user',
            'email' => 'user1@mail.com',
            'password' => bcrypt('password'),
            'role' => 'seniman'
        ])->assignRole('seniman')->userDetail()->create([
            'tanggal_lahir' => $faker->date('Y-m-d H:i:s', 'now'),
            'tempat_lahir' => $faker->city(),
            'biografi' => $faker->text(40),
            'status' => $faker->word(),
            'no_phone' => $faker->e164PhoneNumber,
            'aliran' => $faker->word(),
            'gambar' => $faker->image(base_path('public/assets/images/user/'), 500, 500, 'cats')
        ])->address()->create([
            'no_alamat' => $faker->randomNumber(5, true),
            'alamat' => $faker->cityPrefix,
            'provinsi' => $faker->state,
            'kecamatan' => $faker->citySuffix(),
            'kota' => $faker->city(),
            'desa' => $faker->streetName(),
            'prioritas' => $faker->randomNumber(1),
        ]);

        for ($i = 0; $i < 30; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->freeEmail,
                'password' => bcrypt('password'),
                'role' => $faker->randomElement((['seniman', 'collector']))
            ])->assignRole($faker->randomElement((['seniman', 'collector'])))->assignRole('seniman')->userDetail()->create([
                'tanggal_lahir' => $faker->date('Y-m-d H:i:s', 'now'),
                'tempat_lahir' => $faker->city(),
                'biografi' => $faker->text(40),
                'status' => $faker->word(),
                'no_phone' => $faker->e164PhoneNumber,
                'aliran' => $faker->word(),
                'gambar' => $faker->image(base_path('public/assets/images/user/'), 500, 500, 'cats', true)
            ])->address()->create([
                'no_alamat' => $faker->randomNumber(5),
                'alamat' => $faker->cityPrefix,
                'provinsi' => $faker->state,
                'kecamatan' => $faker->citySuffix(),
                'kota' => $faker->city(),
                'desa' => $faker->streetName(),
                'prioritas' => $faker->randomNumber(1),
            ]);
        }
    }
}
