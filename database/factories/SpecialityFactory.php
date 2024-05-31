<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Speciality;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Speciality>
 */
class SpecialityFactory extends Factory
{
    protected $model = Speciality::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(rand(1,3)),
            'description' => $this->faker->text(rand(10,150)),
            'added_timestamp' => $this->faker->iso8601(),
            'last_changed_admin' => $this->faker->name(),
        ];
    }
}
