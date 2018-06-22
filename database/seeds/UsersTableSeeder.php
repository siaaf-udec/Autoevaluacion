<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Claudia',
            'lastname' => 'admin',
            'email' => 'claudia@app.com',
            'password' => '123456',
            'cedula' => '123',
            'id_estado' => '1'
        ]);
        $user1->assignRole('SUPERADMIN');
        $user1->assignRole('FUENTES_PRIMARIAS');


        $user1 = User::create([
            'name' => 'Alejandro',
            'lastname' => '2',
            'email' => 'alejo@app.com',
            'password' => '123456',
            'cedula' => '12',
            'id_estado' => '1'
        ]);
        $user1->assignRole('FUENTES_PRIMARIAS');

        $user1 = User::create([
            'name' => 'Liz',
            'lastname' => 'Quintero',
            'email' => 'liz@app.com',
            'password' => '123456',
            'cedula' => '1221',
            'id_estado' => '1'
        ]);
        $user1->assignRole('FUENTES_SECUNDARIAS');
    }
}
