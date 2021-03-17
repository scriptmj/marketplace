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

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_name' => $this->faker->colorName,
            'shortDescription' => $this->faker->sentence,
            'longDescription' => $this->faker->text,
            'image_url' => $this->faker->imageUrl(200, 300),
        ];
    }
}