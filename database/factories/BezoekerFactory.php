<?php

namespace Database\Factories;

use App\Models\Bezoeker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bezoeker>
 */
class BezoekerFactory extends Factory
{
    protected $model = Bezoeker::class;

    public function definition(): array
    {
        return [
            'voornaam' => $this->faker->firstName(),
            'achternaam' => $this->faker->lastName(),
            'telefoonnummer' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'start_bezoek' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => $this->faker->randomElement(['inactief']),
        ];
    }
}
