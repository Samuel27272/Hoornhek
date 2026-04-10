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
        return [
            'cel_nummer' => 'A-01',
            'capaciteit' => 1,
            'status' => 'beschikbaar',
            'opmerkingen' => null,
        ];
    }
}
