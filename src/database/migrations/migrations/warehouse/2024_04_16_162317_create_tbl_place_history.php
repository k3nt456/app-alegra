<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_place_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idfood')->unsigned()->comment('Alimento comprado');
            $table->integer('purchased_amount')->default(0);
            $table->string('busy_time')->comment('Tiempo de la solicitud');
            $table->char('status', 1)->default(1)->comment('0:Inactivo, 1:Activo, 2:Eliminado');
            $table->timestamps();

            $table->foreign('idfood')->references('id')->on('tbl_food');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_place_history');
    }
};
