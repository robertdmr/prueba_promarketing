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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // fecha de la nota
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // relación con el usuario
            $table->foreignId('user_noted_id')->constrained('users')->onDelete('cascade'); // relación con el usuario anotado
            $table->text('content'); // contenido de la nota
            $table->integer('aproved')->default(0); // estado de aprobación (0: pendiente, 1: aprobado, 2: rechazado)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
