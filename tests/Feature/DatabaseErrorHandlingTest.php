<?php

use App\Models\User;
use App\Models\Zaak;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('shows a friendly database error on failed form submissions', function () {
    $this->actingAs($user = User::factory()->createOne([
        'rol' => 'beheerder',
    ]));

    $zaaknummer = 'ZK-2026-999';

    Zaak::factory()->createOne([
        'zaaknummer' => $zaaknummer,
        'aangemaakt_door' => $user->id,
    ]);

    $response = $this->from(route('zaken.create'))->post(route('zaken.store'), [
        'zaaknummer' => $zaaknummer,
        'omschrijving' => 'Een tweede zaak met hetzelfde nummer',
        'misdaad_type' => 'diefstal',
        'status' => 'open',
        'opmerkingen' => null,
    ]);

    $response
        ->assertRedirect(route('zaken.create'))
        ->assertSessionHasErrors(['database' => 'De gegevens konden niet worden opgeslagen. Controleer de invoer en probeer het opnieuw.']);
});
