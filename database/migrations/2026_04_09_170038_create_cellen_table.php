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
        Schema::create('cellen', function (Blueprint $table) {
            $table->id();
            $table->string('cel_nummer')->unique(); // bijv. A-01
            $table->unsignedTinyInteger('capaciteit')->default(1);
            $table->enum('status', ['beschikbaar', 'bezet', 'buiten_gebruik'])->default('beschikbaar');
            $table->text('opmerkingen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cellen');
    }
};
