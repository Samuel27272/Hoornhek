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
        Schema::create('documenten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gedetineerde_id')->constrained('gedetineerden')->cascadeOnDelete();
            $table->foreignId('geupload_door')->nullable()->constrained('users')->nullOnDelete();
            $table->string('bestandsnaam');
            $table->string('bestand_pad');
            $table->string('mime_type')->nullable();
            $table->enum('type', [
                'bewijs_document',
                'bewijs_foto',
                'bewijs_video',
                'gespreksverslag',
                'overig',
            ])->default('overig');
            $table->text('omschrijving')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documenten');
    }
};
