<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('linges', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('categorie'); // vetement, maison
            $table->integer('prix');     // en FCFA
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('linges');
    }
};