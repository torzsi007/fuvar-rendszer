<?php

namespace Database\Factories;

use App\Models\Fuvarozo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jarmu>
 */
class JarmuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $markak = ['Mercedes', 'Volvo', 'Scania', 'MAN', 'Iveco', 'Renault', 'DAF'];
        $tipusok = ['Atego', 'FH', 'R-series', 'TGX', 'Stralis', 'T-series', 'XF'];
        
        return [
            'marka' => fake()->randomElement($markak),
            'tipus' => fake()->randomElement($tipusok),
            'rendszam' => strtoupper(fake()->bothify('???-###')),
            'fuvarozo_id' => Fuvarozo::where('role', 'fuvarozo')->inRandomOrder()->first()?->id,
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'updated_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
