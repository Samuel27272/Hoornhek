<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('resource forms expose tighter input constraints', function () {
    $user = User::factory()->createOne([
        'rol' => 'developer',
    ]);
    $today = now()->format('Y-m-d');

    $this->actingAs($user);

    $this->get(route('bezoekers.create'))
        ->assertSuccessful()
        ->assertSee('autocomplete="given-name"', false)
        ->assertSee('autocomplete="tel"', false)
        ->assertSee('maxlength="255"', false);

    $this->get(route('cellen.create'))
        ->assertSuccessful()
        ->assertSee('pattern="[A-Za-z0-9\\-]+"', false)
        ->assertSee('max="999"', false);

    $this->get(route('zaken.create'))
        ->assertSuccessful()
        ->assertSee('pattern="[A-Za-z0-9\\-]+"', false)
        ->assertSee('maxlength="5000"', false);

    $this->get(route('gedetineerden.create'))
        ->assertSuccessful()
        ->assertSee('pattern="[0-9]{9}"', false)
        ->assertSee('pattern="[1-9][0-9]{3}\\s?[A-Za-z]{2}"', false)
        ->assertSee("max=\"{$today}\"", false);
});

test('auth and profile forms expose tighter input constraints', function () {
    $this->get(route('login'))
        ->assertSuccessful()
        ->assertSee('maxlength="255"', false)
        ->assertSee('autocomplete="current-password"', false);
});
