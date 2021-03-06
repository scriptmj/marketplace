<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //SqlFileSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ItemSeeder::class,
            CategoryItemSeeder::class,
            ItemOfferSeeder::class,
            ChatMessagesSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
