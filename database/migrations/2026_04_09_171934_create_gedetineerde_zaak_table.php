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
        Schema::create('gedetineerde_zaak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gedetineerde_id')->constrained('gedetineerden')->cascadeOnDelete();
            $table->foreignId('zaak_id')->constrained('zaken')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gedetineerde_zaak');
    }
};
