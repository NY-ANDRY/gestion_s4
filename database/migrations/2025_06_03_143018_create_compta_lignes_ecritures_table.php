<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compta_lignes_ecritures', function (Blueprint $table) {
            $table->id('id_ligne');
            $table->timestamps();
            $table->unsignedBigInteger('id_ecriture');
            $table->string('numero_compte', 10);
            $table->string('libelle_ligne', 255)->nullable();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->foreign('id_ecriture')->references('id')->on('compta_ecritures')->onDelete('cascade');
            $table->foreign('numero_compte')->references('numero_compte')->on('compta_comptes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lignes_ecritures');
    }
};
