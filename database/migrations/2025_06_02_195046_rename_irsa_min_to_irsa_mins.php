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
        Schema::rename('irsa_min', 'irsa_mins');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('irsa_mins', 'irsa_min');
    }
};
