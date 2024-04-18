<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('iduser')->comment('Usuario que inició la orden');
            $table->bigInteger('idrecipe')->unsigned();
            $table->string('busy_time')->comment('Tiempo en preparación');
            $table->char('status', 1)->default(0)->comment('0:Inactivo/Pendiente, 1:Activo/Entregado, 2:Eliminado, 3:No completado');
            $table->timestamps();

            $table->foreign('idrecipe')->references('id')->on('tbl_recipe');
            $table->foreign('iduser')->references('id')->on('tbl_user');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_orders');
    }
};
