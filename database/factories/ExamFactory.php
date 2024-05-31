<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Exam;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    protected $model = Exam::class;
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
            'link_to_website' => $this->faker->url(),
            'added_timestamp' => $this->faker->iso8601(),
            'last_changed_admin' => $this->faker->name(),
        ];
    }
}
