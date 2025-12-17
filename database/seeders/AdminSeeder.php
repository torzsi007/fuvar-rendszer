<?php

namespace Database\Seeders;

use App\Models\Fuvarozo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Fuvarozo::create([
            'name' => 'Rendszer Admin',
            'email' => 'admin@fuvarrendszer.hu',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        Fuvarozo::create([
            'name' => 'Kiss Péter Fuvarozó',
            'email' => 'fuvarozo@fuvarrendszer.hu',
            'password' => bcrypt('fuvar123'),
            'role' => 'fuvarozo',
        ]);
    }
}
