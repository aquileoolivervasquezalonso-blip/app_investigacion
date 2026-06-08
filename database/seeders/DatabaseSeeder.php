<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ittecomatlan.edu.mx'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'rol' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'investigador@ittecomatlan.edu.mx'],
            [
                'name' => 'Investigador Demo',
                'password' => Hash::make('password'),
                'rol' => 'investigador',
            ]
        );
    }
}
