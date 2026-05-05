<?php

use App\Models\Cel;
use App\Models\Gedetineerde;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('does not create relocation history when a gedetineerde stays in the same cell', function () {
    $user = User::factory()->createOne([
        'rol' => 'developer',
    ]);

    $this->actingAs($user);

    $cel = Cel::factory()->createOne([
        'cel_nummer' => 'A-01',
        'status' => 'bezet',
    ]);

    $gedetineerde = Gedetineerde::factory()->createOne([
        'cel_id' => $cel->id,
        'voornaam' => 'Jan',
        'achternaam' => 'Jansen',
        'straatnaam' => 'Hoofdstraat',
        'huisnummer' => '1',
        'postcode' => '1234 AB',
        'woonplaats' => 'Amsterdam',
        'telefoonnummer' => '0612345678',
        'email' => 'jan@example.com',
        'opmerkingen' => 'Eerste opname',
    ]);

    $response = $this->put(route('gedetineerden.update', $gedetineerde), [
        'bsn_nummer' => $gedetineerde->bsn_nummer,
        'voornaam' => 'Jan',
        'achternaam' => 'Jansen',
        'geboortedatum' => $gedetineerde->geboortedatum->format('Y-m-d'),
        'straatnaam' => 'Hoofdstraat',
        'huisnummer' => '1',
        'postcode' => '1234 AB',
        'woonplaats' => 'Amsterdam',
        'telefoonnummer' => '0612345678',
        'email' => 'jan@example.com',
        'aanhoudingsdatum' => $gedetineerde->aanhoudingsdatum->format('Y-m-d'),
        'datum_schorsing' => null,
        'cel_id' => (string) $cel->id,
        'opmerkingen' => 'Bijgewerkte opmerking',
        'zaken' => [],
    ]);

    $response
        ->assertRedirect(route('gedetineerden.index'));

    expect($gedetineerde->fresh()->opmerkingen)->toBe('Bijgewerkte opmerking');
    $this->assertDatabaseCount('historie', 0);
});
