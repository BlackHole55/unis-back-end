<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\University;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\University>
 */
class UniversityFactory extends Factory
{
    protected $model = University::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(rand(1,4)),
            'description' => $this->faker->text(rand(10,150)),
            'city' => $this->faker->city(),
            'address' => $this->faker->streetAddress(),
            'link_to_website' => $this->faker->url(),
            'added_timestamp' => $this->faker->iso8601(),
            'last_changed_admin' => $this->faker->name(),
        ];
    }
}
