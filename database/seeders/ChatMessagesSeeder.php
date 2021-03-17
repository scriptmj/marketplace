<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatMessage;

class ChatMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatMessage::factory(15)->create();
    }
}
