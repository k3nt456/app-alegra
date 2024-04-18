<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_recipe', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->text('ingredients')->comment('Los ingredientes esta en una estructura array');
            $table->text('amount_ingredients')->comment('La cantidad de ingredientes esta una estructura array');
            $table->text('preparation')->nullable();
            $table->char('status', 1)->default(1)->comment('0:Inactivo, 1:Activo, 2:Eliminado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_recipe');
    }
};
