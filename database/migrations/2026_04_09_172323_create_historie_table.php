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
        Schema::create('historie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gedetineerde_id')->constrained('gedetineerden')->cascadeOnDelete();
            $table->foreignId('uitgevoerd_door')->nullable()->constrained('users')->nullOnDelete();
            $table->string('gebeurtenis'); // bijv. "Overgeplaatst naar cel B-04"
            $table->foreignId('cel_oud')->nullable()->constrained('cellen')->nullOnDelete();
            $table->foreignId('cel_nieuw')->nullable()->constrained('cellen')->nullOnDelete();
            $table->enum('type', [
                'registratie',
                'overplaatsing',
                'ontslag',
                'bewerking',
                'bewijs_toegevoegd',
                'gesprek',
                'overig',
            ])->default('overig');
            $table->text('opmerkingen')->nullable();
            $table->timestamp('datum')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historie');
    }
};
