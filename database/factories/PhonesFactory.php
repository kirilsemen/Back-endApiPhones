<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhonesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model' => null,
            'price' => null,
            'quantity' => null,
        ];
    }
}
