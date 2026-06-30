<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $roles = \App\Models\Role::pluck('id', 'name');

        \App\Models\User::all()->each(function ($user) use ($roles) {
            if ($user->rol && isset($roles[$user->rol])) {
                $user->role_id = $roles[$user->rol];
                $user->save();
            }
        });
    }

    public function down(): void
    {
        //
    }
};
