<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\University;
use App\Models\Dorm;
use App\Models\Speciality;
use App\Models\SpecialityUniversity;
use App\Models\Exam;

use Faker\Generator;
use Illuminate\Container\Container;

class DatabaseSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        collect(range(0,19))
        ->each(function () {
        University::factory()
            ->has(Dorm::factory()->count(rand(1,2)))
            ->create();
        });

        Speciality::factory()->count(20)->create();

        $specialties = Speciality::all();

        University::all()->each(function ($university) use ($specialties) { 
            $university->specialties()->attach(
                $specialties->random(rand(1, 10))->pluck('id')->toArray(), [
                    'price_per_year_tenge' => $this->faker->randomNumber(rand(5,7), true),
                    'added_timestamp' => $this->faker->iso8601(),
                    'last_changed_admin' => $this->faker->name(),
                ]
            ); 
        });

        Exam::factory()->count(20)->create();

        $exams = Exam::all();

        SpecialityUniversity::all()->each(function ($specialityUniversity) use ($exams) {
            $specialityUniversity->exams()->attach(
                $exams->random(rand(1, 4))->pluck('id')->toArray()
            );
        });
    }
}
