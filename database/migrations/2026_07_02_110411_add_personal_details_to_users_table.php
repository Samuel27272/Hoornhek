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
        Schema::table('users', function (Blueprint $table) {
            $table->date('geboortedatum')->nullable()->after('email');
            $table->string('straatnaam')->nullable()->after('geboortedatum');
            $table->unsignedInteger('huisnummer')->nullable()->after('straatnaam');
            $table->string('postcode', 7)->nullable()->after('huisnummer');
            $table->string('woonplaats')->nullable()->after('postcode');
            $table->string('telefoonnummer', 20)->nullable()->after('woonplaats');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['geboortedatum', 'straatnaam', 'huisnummer', 'postcode', 'woonplaats', 'telefoonnummer']);
        });
    }
};
