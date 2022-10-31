<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class Permessions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'collector']);
        Role::create(['name' => 'seniman']);
    }
}
