<?php

namespace Database\Seeders;

use App\Models\Bezoeker;
use App\Models\User;
use App\Models\Cel;
use App\Models\Gedetineerde;
use App\Models\Zaak;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $gebruikers = [
            'bewaker' => ['Jochem de Visser', 'Leon Maljaars', 'Mark De Jong'],
            'portier' => ['Gert van Dongen', 'Luuk van den Tol', 'Wijnand Stolk'],
            'maatschappelijk_werker' => ['Jaco Offermans', 'Lennert van Dijke', 'Bart van der Stelt'],
            'beheerder' => ['Samuel Burggraaf'],
        ];

        foreach ($gebruikers as $roleName => $namen) {
            $role = Role::where('name', $roleName)->first();

            foreach ($namen as $naam) {
                $emailLocal = Str::of($naam)->lower()->replace(' ', '.')->replace("'", '');

                User::factory()->create([
                    'name' => $naam,
                    'email' => $emailLocal . '@hoornhek.nl',
                    'role_id' => $role->id,
                ]);
            }
        }

        $blocks = ['A', 'B', 'C'];
        foreach ($blocks as $block) {
            for ($n = 1; $n <= 32; $n++) {
                $num = sprintf('%s-%02d', $block, $n);
                Cel::create([
                    'cel_nummer' => $num,
                    'capaciteit' => 1,
                    'status' => 'beschikbaar',
                    'block' => $block,
                ]);
            }
        }

        $gedetineerden = Gedetineerde::factory()->count(10)->create()->each(function ($g) {

            $cel = Cel::whereDoesntHave('gedetineerden')->inRandomOrder()->first();
            if ($cel) {
                $g->cel_id = $cel->id;
                $g->save();

                if ($cel->gedetineerden()->count() >= $cel->capaciteit) {
                    $cel->status = 'bezet';
                    $cel->save();
                }
            }
        });

        foreach ($gedetineerden as $gedetineerde) {
            $zaak = Zaak::factory()->create([
                'aangemaakt_door' => null,
            ]);

            $gedetineerde->zaken()->attach($zaak->id);
        }

        Bezoeker::factory()->count(10)->create();
    }
}
