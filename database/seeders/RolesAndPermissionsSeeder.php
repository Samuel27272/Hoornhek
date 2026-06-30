<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Gedetineerden
            ['name' => 'gedetineerden.view',      'display_name' => 'Gedetineerden bekijken',    'group' => 'Gedetineerden'],
            ['name' => 'gedetineerden.create',    'display_name' => 'Gedetineerden aanmaken',    'group' => 'Gedetineerden'],
            ['name' => 'gedetineerden.edit',      'display_name' => 'Gedetineerden bewerken',    'group' => 'Gedetineerden'],
            ['name' => 'gedetineerden.delete',    'display_name' => 'Gedetineerden verwijderen', 'group' => 'Gedetineerden'],
            ['name' => 'gedetineerden.ontslaan',  'display_name' => 'Gedetineerden ontslaan',    'group' => 'Gedetineerden'],
            ['name' => 'gedetineerden.herplaatsen', 'display_name' => 'Gedetineerden herplaatsen', 'group' => 'Gedetineerden'],

            // Documenten
            ['name' => 'documenten.upload',       'display_name' => 'Documenten uploaden',       'group' => 'Documenten'],
            ['name' => 'documenten.delete',       'display_name' => 'Documenten verwijderen',    'group' => 'Documenten'],

            // Zaken
            ['name' => 'zaken.view',              'display_name' => 'Zaken bekijken',            'group' => 'Zaken'],
            ['name' => 'zaken.create',            'display_name' => 'Zaken aanmaken',            'group' => 'Zaken'],
            ['name' => 'zaken.edit',              'display_name' => 'Zaken bewerken',            'group' => 'Zaken'],
            ['name' => 'zaken.delete',            'display_name' => 'Zaken verwijderen',         'group' => 'Zaken'],

            // Cellen
            ['name' => 'cellen.view',             'display_name' => 'Cellen bekijken',           'group' => 'Cellen'],
            ['name' => 'cellen.create',           'display_name' => 'Cellen aanmaken',           'group' => 'Cellen'],
            ['name' => 'cellen.edit',             'display_name' => 'Cellen bewerken',           'group' => 'Cellen'],
            ['name' => 'cellen.delete',           'display_name' => 'Cellen verwijderen',        'group' => 'Cellen'],

            // Bezoekers
            ['name' => 'bezoekers.view',          'display_name' => 'Bezoekers bekijken',        'group' => 'Bezoekers'],
            ['name' => 'bezoekers.create',        'display_name' => 'Bezoekers aanmaken',        'group' => 'Bezoekers'],
            ['name' => 'bezoekers.edit',          'display_name' => 'Bezoekers bewerken',        'group' => 'Bezoekers'],
            ['name' => 'bezoekers.delete',        'display_name' => 'Bezoekers verwijderen',     'group' => 'Bezoekers'],

            // Beheer
            ['name' => 'admin.access',            'display_name' => 'Beheermodule toegang',      'group' => 'Beheer'],
            ['name' => 'users.view',              'display_name' => 'Gebruikers bekijken',       'group' => 'Beheer'],
            ['name' => 'users.create',            'display_name' => 'Gebruikers aanmaken',       'group' => 'Beheer'],
            ['name' => 'users.edit',              'display_name' => 'Gebruikers bewerken',       'group' => 'Beheer'],
            ['name' => 'users.delete',            'display_name' => 'Gebruikers verwijderen',    'group' => 'Beheer'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p['name']], $p);
        }

        $rollen = [
            'developer' => Permission::all(), // alles

            'bewaker' => Permission::whereIn('name', [
                'gedetineerden.view',
                'gedetineerden.create',
                'gedetineerden.edit',
                'gedetineerden.delete',
                'gedetineerden.ontslaan',
                'gedetineerden.herplaatsen',
                'documenten.upload',
                'documenten.delete',
                'zaken.view',
                'zaken.create',
                'zaken.edit',
                'zaken.delete',
                'cellen.view',
                'cellen.create',
                'cellen.edit',
                'cellen.delete',
                'bezoekers.view',
                'bezoekers.create',
                'bezoekers.edit',
                'bezoekers.delete',
            ])->get(),

            'portier' => Permission::whereIn('name', [
                'bezoekers.view',
                'bezoekers.create',
                'bezoekers.edit',
                'bezoekers.delete',
            ])->get(),

            'maatschappelijk_werker' => Permission::whereIn('name', [
                'gedetineerden.view',
                'documenten.upload',
                'documenten.delete',
            ])->get(),
        ];

        foreach ($rollen as $rolNaam => $permissions) {
            $rol = Role::firstOrCreate(
                ['name' => $rolNaam],
                ['display_name' => ucfirst(str_replace('_', ' ', $rolNaam))]
            );
            $rol->permissions()->sync($permissions);
        }
    }
}
