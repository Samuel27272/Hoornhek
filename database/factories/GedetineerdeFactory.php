<?php

namespace Database\Factories;

use App\Models\Gedetineerde;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gedetineerde>
 */
class GedetineerdeFactory extends Factory
{
    protected $model = Gedetineerde::class;

    public function definition(): array
    {
        $first = $this->faker->firstName();
        $last = $this->faker->lastName();
        $bsn = (string) $this->faker->unique()->numerify('#########');

        return [
            'bsn_nummer' => $bsn,
            'voornaam' => $first,
            'achternaam' => $last,
            'geboortedatum' => $this->faker->date('Y-m-d', '-18 years'),
            'straatnaam' => $this->faker->streetName(),
            'huisnummer' => (string) $this->faker->numberBetween(1, 300),
            'postcode' => $this->faker->postcode(),
            'woonplaats' => $this->faker->city(),
            'telefoonnummer' => $this->faker->optional()->phoneNumber(),
            'email' => $this->faker->optional()->safeEmail(),
            'foto_pad' => null,
            'aanhoudingsdatum' => $this->faker->date('Y-m-d', 'now'),
            'datum_schorsing' => null,
            'status' => 'actief',
            'cel_id' => null,
            'opmerkingen' => $this->faker->optional()->sentence(),
        ];
    }
}
