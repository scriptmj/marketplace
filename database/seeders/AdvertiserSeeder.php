<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;
use App\Models\Advertiser;

class AdvertiserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertiser::factory()->forUser(['id' => 6])->hasItems(3)->create();
        Advertiser::factory()->forUser(['id' => 7])->hasItems(3)->create();
        Advertiser::factory()->forUser(['id' => 8])->hasItems(3)->create();
        Advertiser::factory()->forUser(['id' => 9])->hasItems(3)->create();
        Advertiser::factory()->forUser(['id' => 10])->hasItems(3)->create();
        User::find(6)->update(['advertiser_id' => 1]);
        User::find(7)->update(['advertiser_id' => 2]);
        User::find(8)->update(['advertiser_id' => 3]);
        User::find(9)->update(['advertiser_id' => 4]);
        User::find(10)->update(['advertiser_id' => 5]);
    }
}
