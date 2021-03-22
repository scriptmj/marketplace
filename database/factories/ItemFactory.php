<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    private $itemList = ["bowl", "beef", "headphones", "key chain", "tooth picks", "stop sign", "scotch tape", "hanger", "shirt", "newspaper", "sand paper", "shawl",
    "computer", "perfume", "couch", "chair", "mirror", "boom box", "television", "clothes", "truck", "air freshener", "socks", "blouse", "milk", "pencil", "bottle",
    "lamp", "seat belt", "brocolli", "shampoo", "soy sauce packet", "thermostat", "cup", "rusty nail", "canvas", "plastic fork", "helmet", "chocolate",
    "drill press", "keys", "tire swing", "mop", "flowers", "screw", "packing peanuts", "greeting card", "slipper", "bookmark", "chalk"];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_name' => $this->itemList[rand(0,49)],
            'short_description' => $this->faker->sentence,
            'long_description' => $this->faker->text,
            'image' => 'https://picsum.photos/600?random='.rand(1,100),
        ];
    }
}
