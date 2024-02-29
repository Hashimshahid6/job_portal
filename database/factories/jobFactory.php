<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class jobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'user_id' => 1,
            'description' => $this->faker->paragraph,
            'category_id' => 1,
            'job_type_id' => 1,
            'vacancy' => $this->faker->numberBetween(1, 10),
            'salary' => $this->faker->numberBetween(1000, 9000),
            'location' => $this->faker->city,
            'benefits' => $this->faker->paragraph,
            'responsibility' => $this->faker->paragraph,
            'qualifications' => $this->faker->paragraph,
            'keywords' => $this->faker->sentence,
            'experience' => $this->faker->numberBetween(1, 10),
            'company_name' => $this->faker->company,
            'company_location' => $this->faker->city,
            'company_website' => $this->faker->url,

        ];
    }
}
