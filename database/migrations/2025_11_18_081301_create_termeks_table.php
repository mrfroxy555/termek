<?php
// database/migrations/2024_01_01_000000_create_termeks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('termeks', function (Blueprint $table) {
            $table->id();
            $table->string('tanterem')->unique(); // Egyedi teremszám
            $table->integer('befogadokepesseg');
            $table->boolean('projektor')->default(false);
            $table->boolean('tv')->default(false);
            $table->integer('tv_meret')->nullable(); // TV méret, ha van TV
            $table->integer('berbeadas_osszege'); // 500 vagy 1000-re végződik
            $table->integer('szamitogepek_szama');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('termeks');
    }
};