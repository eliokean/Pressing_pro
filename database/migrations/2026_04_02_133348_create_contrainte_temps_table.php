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
        Schema::create('contrainte_temps', function (Blueprint $table) {
            $table->id();
            $table->string('label');         // ex: "Pluie", "Nuit"
            $table->decimal('coefficient', 4, 2); // ex: 1.3
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrainte_temps');
    }
};
