<?php

namespace Database\Seeders;

use App\Models\Fuvarozo;
use App\Models\Munka;
use App\Models\Jarmu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Munka::truncate();
        Jarmu::truncate();
        Fuvarozo::where('email', '!=', '')->delete();

        //  Admin létrehozása
        $admin = Fuvarozo::create([
            'name' => 'Admin Főnök',
            'email' => 'admin@fuvar.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 5 fuvarozó létrehozása
        $fuvarozok = [];
        for ($i = 1; $i <= 5; $i++) {
            $fuvarozok[] = Fuvarozo::create([
                'name' => 'Fuvarozó ' . $i,
                'email' => 'fuvarozo' . $i . '@fuvar.test',
                'password' => Hash::make('password'),
                'role' => 'fuvarozo',
                'email_verified_at' => now(),
            ]);
        }

        // Járművek létrehozása
        foreach ($fuvarozok as $fuvarozo) {
            Jarmu::create([
                'marka' => ['Mercedes', 'Volvo', 'Scania', 'MAN'][array_rand(['Mercedes', 'Volvo', 'Scania', 'MAN'])],
                'tipus' => 'Típus-' . rand(100, 999),
                'rendszam' => 'ABC-' . rand(100, 999),
                'fuvarozo_id' => $fuvarozo->id,
            ]);
        }

        // 15 munka létrehozása
        $statuszok = ['kiosztva', 'folyamatban', 'elvegezve', 'sikertelen'];
        for ($i = 1; $i <= 15; $i++) {
            Munka::create([
                'kiindulo_cim' => 'Budapest, Király utca ' . rand(1, 100),
                'erkezesi_cim' => 'Debrecen, Piac utca ' . rand(1, 100),
                'cimzett_nev' => 'Ügyfél ' . $i,
                'cimzett_telefon' => '+36' . rand(20, 99) . rand(1000000, 9999999),
                'statusz' => $statuszok[array_rand($statuszok)],
                'fuvarozo_id' => rand(0, 1) ? $fuvarozok[array_rand($fuvarozok)]->id : null,
            ]);
        }

        echo "Seeding completed!\n";
        echo "- Admin: admin@fuvar.test / admin123\n";
        echo "- Fuvarozók: fuvarozo1@fuvar.test ... fuvarozo5@fuvar.test / password\n";
    }
}
