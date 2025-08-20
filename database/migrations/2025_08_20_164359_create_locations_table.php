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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');        // Nome della location
            $table->string('address');     // Indirizzo
            $table->string('city');        // Città
            $table->string('province');    // Provincia
            $table->string('zip_code')->nullable();  // CAP
            $table->string('country')->default('Italia'); // Paese di default
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
