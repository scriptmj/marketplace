<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Carbon\Carbon;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::factory()->count(5)->hasOffers(rand(1,10))->create([
            'sold' => true,
            'marked_as_sold' => Carbon::now(),
            'user_id' => rand(1,10),
        ]);
        Item::factory()->count(6)->hasOffers(rand(1,10))->create([
            'sold' => true,
            'marked_as_sold' => Carbon::now(),
            'user_id' => rand(1,10),
        ]);
        Item::factory()->count(3)->hasOffers(rand(1,10))->create([
            'sold' => true,
            'marked_as_sold' => Carbon::now(),
            'user_id' => rand(1,10),
        ]);
        Item::factory()->count(2)->hasOffers(rand(1,10))->create([
            'sold' => true,
            'marked_as_sold' => Carbon::now(),
            'user_id' => rand(1,10),
        ]);
    }
}
