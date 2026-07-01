<?php

namespace Database\Factories;

use App\Models\Cel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cel>
 */
class CelFactory extends Factory
{
    protected $model = Cel::class;

    public function definition(): array
    {
        $block = fake()->randomElement(['A', 'B', 'C']);
        $number = fake()->unique()->numberBetween(1, 32);

        return [
            'cel_nummer' => sprintf('%s-%02d', $block, $number),
            'block' => $block,
            'capaciteit' => 1,
            'status' => 'beschikbaar',
            'opmerkingen' => null,
        ];
    }
}
