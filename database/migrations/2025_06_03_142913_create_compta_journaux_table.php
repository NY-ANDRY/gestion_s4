<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compta_journaux', function (Blueprint $table) {
            $table->id();
            $table->string('code_journal', 5)->primary();
            $table->string('libelle', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journaux');
    }
};
