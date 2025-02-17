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
        Schema::create('avaliations', function (Blueprint $table) {
            $table->id();
            // Cria uma coluna com o id do avaliador (FK da tabela users)
            $table->foreignId('avaliator_id')->constrained('users')->onDelete('cascade'); 
            // Cria uma coluna com o id do avaliado (FK da tabela users)
            $table->foreignId('avaliated_id')->constrained('users')->onDelete('cascade'); 
            $table->boolean('like');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliations');
    }
};
