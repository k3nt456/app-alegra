<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_food', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->text('referential_image')->nullable();
            $table->char('status', 1)->default(1)->comment('0:Inactivo, 1:Activo, 2:Eliminado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_food');
    }
};
