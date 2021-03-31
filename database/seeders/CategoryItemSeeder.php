<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Category;

class CategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0 ; $i < 50; $i++){
            DB::table('category_item')->insertOrIgnore(
                ['category_id' => rand(1,Category::count()), 'item_id' => rand(1, Item::count())]);
        }
    }
}
