<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price' => rand(1,100),
            'user_id' => rand(1, User::count()),
            'item_id'=> rand(1, Item::count()),
        ];
    }
}
