<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $tita = User::where('email', 'tita.canada@kaonta.test')->first();
        $myEatery = Eatery::where('slug', 'carinderia-ni-canada')->first();

        // Tita's required 5-star review
        Review::create([
            'eatery_id' => $myEatery->id,
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Cañada.',
        ]);

        // 2 more reviews on your eatery (total 3)
        Review::factory()->count(2)->create([
            'eatery_id' => $myEatery->id,
            'user_id' => fn () => $users->where('id', '!=', $tita->id)->random()->id,
        ]);

        // 0-6 reviews on other open eateries; closed eateries get none
        $otherOpenEateries = Eatery::where('is_open', true)
            ->where('id', '!=', $myEatery->id)
            ->get();

        foreach ($otherOpenEateries as $eatery) {
            $count = rand(0, 6);
            for ($i = 0; $i < $count; $i++) {
                Review::factory()->create([
                    'eatery_id' => $eatery->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}