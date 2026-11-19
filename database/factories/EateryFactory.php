<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EateryFactory extends Factory
{
    public function definition(): array
    {
        $name = 'Carinderia ' . fake()->unique()->company();
        return [
            'district_id' => District::inRandomOrder()->first()?->id ?? 1,
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->streetAddress() . ', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->randomElement(['Sinigang na Baboy', 'Beef Pochero', 'Pinakbet', 'Grilled Tuna Belly', 'Balbacua', 'Chicken Adobo']),
            'is_open' => true,
        ];
    }

    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_open' => false,
        ]);
    }
}