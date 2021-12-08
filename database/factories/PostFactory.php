<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
     
        return [
            'title' => $this->faker->title(),
            'content' =>  $this->faker->text(maxNbChars: 400),
            'date_written' =>  now(),
            'featured_image' => $this->faker->imageUrl(),
            'votes_up' => $this->faker->numberBetween( 1 , 100 ),
            'votes_down' => $this->faker->numberBetween(1 , 100 ),
            'user_id' =>  $this->faker->numberBetween(1 , 50 ),
            'category_id' =>  $this->faker->numberBetween(1 , 15 ),
        ];
    }
}
