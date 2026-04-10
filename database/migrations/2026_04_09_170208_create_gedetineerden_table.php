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
        Schema::create('gedetineerden', function (Blueprint $table) {
            $table->id();
            $table->string('bsn_nummer', 9)->unique();
            $table->string('voornaam');
            $table->string('achternaam');
            $table->date('geboortedatum');
            $table->string('straatnaam');
            $table->string('huisnummer');
            $table->string('postcode');
            $table->string('woonplaats');
            $table->string('telefoonnummer')->nullable();
            $table->string('email')->nullable();
            $table->string('foto_pad')->nullable(); // opgeslagen pasfoto
            $table->date('aanhoudingsdatum');
            $table->date('datum_schorsing')->nullable(); // ontslagdatum
            $table->enum('status', ['actief', 'inactief'])->default('actief');
            $table->foreignId('cel_id')->nullable()->constrained('cellen')->nullOnDelete();
            $table->text('opmerkingen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gedetineerden');
    }
};
