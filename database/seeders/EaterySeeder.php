<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        $poblacion = District::where('name', 'Poblacion')->first();
        $sukiFeature = Feature::where('name', 'Suki ni Cañada')->first();
        $budgetFeature = Feature::where('name', 'Budget Meal')->first();

        // 1. Hand-made eatery
        $myEatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => 'Carinderia ni Cañada',
            'slug' => Str::slug('Carinderia ni Cañada'),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $myEatery->features()->sync([$sukiFeature->id, $budgetFeature->id]);

        $myEatery->permit()->create([
            'permit_no' => 'DVO-2026-0812',
            'expires_on' => '2027-08-12',
        ]);

        $myEatery->dishes()->createMany([
            ['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true],
            ['name' => 'Kinilaw na Tuna', 'price' => 120.00, 'is_bestseller' => false],
            ['name' => 'Durian Shake', 'price' => 75.00, 'is_bestseller' => false],
        ]);

        // 2. 14 Factory eateries (11 open, 3 closed)
        $allFeatures = Feature::all();
        $openEateries = Eatery::factory()->count(11)->create();
        $closedEateries = Eatery::factory()->count(3)->closed()->create();

        $factoryEateries = $openEateries->concat($closedEateries);

        foreach ($factoryEateries as $index => $eatery) {
            // Make sure the first factory eatery has an expired permit
            if ($index === 0) {
                Permit::factory()->create([
                    'eatery_id' => $eatery->id,
                    'expires_on' => now()->subMonths(2)->format('Y-m-d'),
                ]);
            } else {
                Permit::factory()->create([
                    'eatery_id' => $eatery->id,
                ]);
            }

            Dish::factory()->count(rand(2, 5))->create([
                'eatery_id' => $eatery->id,
            ]);

            $eatery->features()->attach(
                $allFeatures->random(rand(1, 3))->pluck('id')
            );
        }
    }
}