<?php

namespace Database\Factories;

use App\Models\Zaak;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Zaak>
 */
class ZaakFactory extends Factory
{
    protected $model = Zaak::class;

    public function definition(): array
    {
        static $counter = 1;
        $nummer = sprintf('ZK-%s-%03d', date('Y'), $counter++);

        return [
            'zaaknummer' => $nummer,
            'omschrijving' => $this->faker->sentence(6),
            'misdaad_type' => $this->faker->randomElement(['diefstal', 'mishandeling', 'overig', null]),
            'status' => 'open',
            'datum_aangemaakt' => $this->faker->date('Y-m-d', 'now'),
            'datum_gesloten' => null,
            'opmerkingen' => null,
            'aangemaakt_door' => null,
        ];
    }
}
