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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('cifCliente');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->date('fecha');
            $table->string('desc');
            $table->integer('precioUnitario');
            $table->integer('precioTotal');
            $table->integer('iva');
            $table->integer('precioFinal');
            $table->boolean('estado');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
