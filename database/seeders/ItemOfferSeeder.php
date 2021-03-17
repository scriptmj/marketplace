<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class ItemOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Offer::factory(15)->create();
    }
}
