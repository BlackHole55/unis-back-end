<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dorm;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dorm>
 */
class DormFactory extends Factory
{
    protected $model = Dorm::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city' => $this->faker->city(),
            'address' => $this->faker->streetAddress(),
            'description' => $this->faker->text(rand(10,150)),
            'price_tenge' => $this->faker->randomNumber(rand(5,7), true),
            'added_timestamp' => $this->faker->iso8601(),
            'last_changed_admin' => $this->faker->name(),
        ];
    }
}
