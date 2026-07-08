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
        Schema::create('zaken', function (Blueprint $table) {
            $table->id();
            $table->string('zaaknummer')->unique();
            $table->string('omschrijving');
            $table->string('misdaad_type')->nullable();
            $table->enum('status', ['open', 'gesloten', 'in_behandeling'])->default('open');
            $table->date('datum_aangemaakt');
            $table->date('datum_gesloten')->nullable();
            $table->text('opmerkingen')->nullable();
            $table->foreignId('aangemaakt_door')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zaken');
    }
};
