<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)
            ->create();
        User::factory(5)
            ->hasItems(3)
            ->create();
        DB::table('users')->insert([
            'name' => 'Test',
            'email' => 'test@test.nl',
            'password' => Hash::make('password'),
        ]);
    }
}
