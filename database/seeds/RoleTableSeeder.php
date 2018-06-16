<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'SUPERADMIN']);
        Role::create(['name' => 'FUENTES_PRIMARIAS']);
        Role::create(['name' => 'FUENTES_SECUNDARIAS']);
    }
}
