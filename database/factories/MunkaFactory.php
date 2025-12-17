<?php

namespace Database\Factories;

use App\Models\Fuvarozo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Munka>
 */
class MunkaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuszok = ['kiosztva', 'folyamatban', 'elvegezve', 'sikertelen'];
        
        return [
            'kiindulo_cim' => fake()->address(),
            'erkezesi_cim' => fake()->address(),
            'cimzett_nev' => fake()->name(),
            'cimzett_telefon' => fake()->phoneNumber(),
            'statusz' => fake()->randomElement($statuszok),
            'fuvarozo_id' => fake()->boolean(70) ? Fuvarozo::where('role', 'fuvarozo')->inRandomOrder()->first()?->id : null,
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'updated_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
