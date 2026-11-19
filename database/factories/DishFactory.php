<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Lumpiang Shanghai', 'Pancit Canton', 'Adobong Pusit', 'Dinuguan', 'Bicol Express', 'Lechon Kawali', 'Halo-Halo', 'Nilagang Baka']),
            'price' => fake()->randomFloat(2, 35, 180),
            'is_bestseller' => fake()->boolean(30),
        ];
    }
}