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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            // Campi location integrati direttamente
            $table->string('location_name')->nullable();        // Nome della location
            $table->string('location_address')->nullable();     // Indirizzo
            $table->string('location_city')->nullable();        // Città
            $table->string('location_province')->nullable();    // Provincia
            $table->string('location_zip_code')->nullable();    // CAP
            $table->string('location_country')->default('Italia'); // Paese di default
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->integer('max_participants')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
