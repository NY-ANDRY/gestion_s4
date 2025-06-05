<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compta_ecritures', function (Blueprint $table) {
            $table->id('id');
            $table->date('date_ecriture');
            $table->string('piece_reference', 50)->nullable();
            $table->string('libelle_ecriture', 255)->nullable();
            $table->string('journal_code', 5);
            $table->timestamps();
            $table->foreign('journal_code')->references('code_journal')->on('compta_journaux');
            $table->unsignedBigInteger('id_exercice')->nullable();
            $table->foreign('id_exercice')->references('id')->on('compta_exercices');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecritures');
    }
};
