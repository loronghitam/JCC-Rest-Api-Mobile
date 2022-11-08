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
        $fakers = Faker\Factory::create('id_ID');
        $faker = Faker\Factory::create();
        User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => bcrypt('password'),
            'role' => 'collector',
        ])->assignRole('collector')->userDetail()->create([
            'tanggal_lahir' => $fakers->date('Y-m-d', 'now'),
            'tempat_lahir' => $fakers->city(),
            'biografi' => $fakers->text(40),
            'status' => $fakers->word(),
            'no_phone' => $fakers->PhoneNumber,
            'aliran' => $fakers->word(),
            'gambar' => $fakers->imageUrl(150, 150, 'people'),
        ])->address()->create([
            'no_alamat' => $fakers->randomNumber(5),
            'alamat' => $fakers->alamat,
            'provinsi' => $fakers->state,
            'kecamatan' => $fakers->citySuffix(),
            'kota' => $fakers->city(),
            'desa' => $fakers->streetName(),
            'prioritas' => $fakers->randomNumber('1',),
        ]);
        User::create([
            'name' => 'user',
            'email' => 'user1@mail.com',
            'password' => bcrypt('password'),
            'role' => 'seniman'
        ])->assignRole('seniman')->userDetail()->create([
            'tanggal_lahir' => $fakers->date('Y-m-d H:i:s', 'now'),
            'tempat_lahir' => $fakers->city(),
            'biografi' => $fakers->text(40),
            'status' => $fakers->word(),
            'no_phone' => $fakers->PhoneNumber,
            'aliran' => $fakers->word(),
            'gambar' => $fakers->imageUrl(150, 150, 'people')
        ])->address()->create([
            'no_alamat' => $fakers->randomNumber(5, true),
            'alamat' => $fakers->alamat,
            'provinsi' => $fakers->state,
            'kecamatan' => $fakers->citySuffix(),
            'kota' => $fakers->city(),
            'desa' => $fakers->streetName(),
            'prioritas' => $fakers->randomNumber(1),
        ]);

        for ($i = 0; $i < 30; $i++) {
            User::create([
                'name' => $fakers->name,
                'email' => $fakers->freeEmail,
                'password' => bcrypt('password'),
                'role' => $fakers->randomElement((['seniman', 'collector']))
            ])->assignRole($fakers->randomElement((['seniman', 'collector'])))->assignRole('seniman')->userDetail()->create([
                'tanggal_lahir' => $fakers->date('Y-m-d H:i:s', 'now'),
                'tempat_lahir' => $fakers->city(),
                'biografi' => $fakers->text(40),
                'status' => $fakers->word(),
                'no_phone' => $fakers->phoneNumber(),
                'aliran' => $fakers->word(),
                'gambar' => $fakers->imageUrl(150, 150, 'people')
            ])->address()->create([
                'no_alamat' => $fakers->randomNumber(5),
                'alamat' => $fakers->alamat,
                'provinsi' => $fakers->state,
                'kecamatan' => $fakers->stateAbbr(),
                'kota' => $fakers->city(),
                'desa' => $fakers->streetName(),
                'prioritas' => $fakers->randomNumber(1),
            ]);
        }
    }
}
