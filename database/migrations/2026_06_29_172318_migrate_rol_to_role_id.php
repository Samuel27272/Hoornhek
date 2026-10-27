<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $roles = Role::pluck('id', 'name');

        User::all()->each(function ($user) use ($roles) {
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
