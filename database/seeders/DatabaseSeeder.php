<?php

namespace Database\Seeders;

use App\Models\Bezoeker;
use App\Models\User;
use App\Models\Cel;
use App\Models\Gedetineerde;
use App\Models\Zaak;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users: 3 per role except developer 1
        $roles = [
            'bewaker' => 3,
            'portier' => 3,
            'maatschappelijk_werker' => 3,
            'developer' => 1,
        ];

        foreach ($roles as $role => $count) {
            for ($i = 1; $i <= $count; $i++) {
                $name = ucfirst(str_replace('_', ' ', $role)) . ' ' . $i;
                $emailLocal = strtolower(str_replace(' ', '', $name));

                User::factory()->create([
                    'name' => $name,
                    'email' => $emailLocal . '@hoornhek.nl',
                    'rol' => $role,
                ]);
            }
        }

        // Cells A-01..A-33, B-01..B-33, C-01..C-33
        $blocks = ['A', 'B', 'C'];
        foreach ($blocks as $block) {
            for ($n = 1; $n <= 33; $n++) {
                $num = sprintf('%s-%02d', $block, $n);
                Cel::create([
                    'cel_nummer' => $num,
                    'capaciteit' => 1,
                    'status' => 'beschikbaar',
                ]);
            }
        }

        // Gedetineerden: 10 — assign to cells respecting capaciteit (1)
        $gedetineerden = Gedetineerde::factory()->count(10)->create()->each(function ($g) {
            // find a cell without occupants (respecting capaciteit)
            $cel = Cel::whereDoesntHave('gedetineerden')->inRandomOrder()->first();
            if ($cel) {
                $g->cel_id = $cel->id;
                $g->save();

                // if cell reached capacity, mark as 'bezet'
                if ($cel->gedetineerden()->count() >= $cel->capaciteit) {
                    $cel->status = 'bezet';
                    $cel->save();
                }
            }
        });

        // For each gedetineerde create one zaak and attach
        foreach ($gedetineerden as $gedetineerde) {
            $zaak = Zaak::factory()->create([
                'aangemaakt_door' => null,
            ]);

            $gedetineerde->zaken()->attach($zaak->id);
        }

        Bezoeker::factory()->count(10)->create();
    }
}
