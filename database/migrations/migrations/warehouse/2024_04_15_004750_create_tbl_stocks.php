<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idfood')->unsigned();
            $table->integer('amount')->default(0);
            $table->char('status', 1)->default(1)->comment('0:Inactivo, 1:Activo, 2:Eliminado');
            $table->timestamps();

            $table->foreign('idfood')->references('id')->on('tbl_food');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_stocks');
    }
};
