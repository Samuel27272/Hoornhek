<?php

use App\Models\Gedetineerde;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('rejects duplicate bsn numbers with a specific validation error', function () {
    $user = User::factory()->createOne([
        'rol' => 'beheerder',
    ]);

    $this->actingAs($user);

    $bsn = '123456789';

    Gedetineerde::factory()->createOne([
        'bsn_nummer' => $bsn,
    ]);

    $response = $this->from(route('gedetineerden.create'))->post(route('gedetineerden.store'), [
        'bsn_nummer' => $bsn,
        'voornaam' => 'Jan',
        'achternaam' => 'Jansen',
        'geboortedatum' => '1990-01-01',
        'straatnaam' => 'Hoofdstraat',
        'huisnummer' => '1',
        'postcode' => '1234 AB',
        'woonplaats' => 'Amsterdam',
        'telefoonnummer' => '0612345678',
        'email' => 'jan@example.com',
        'aanhoudingsdatum' => '2026-04-16',
        'datum_schorsing' => null,
        'cel_id' => null,
        'opmerkingen' => null,
        'zaken' => [],
    ]);

    $response
        ->assertRedirect(route('gedetineerden.create'))
        ->assertSessionHasErrors(['bsn_nummer' => 'Dit BSN-nummer is al in gebruik.']);
});
