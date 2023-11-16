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
        Schema::create('DetailProductionStationLine', function (Blueprint $table) {
            $table->unsignedInteger('FK_Id_Station');
            $table->unsignedSmallInteger('FK_Id_ProdStationLine');

            $table->foreign('FK_Id_Station')->references('Id_Station')
                ->on('Station')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('FK_Id_ProdStationLine')->references('Id_ProdStationLine')
                ->on('ProductStationLine')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DetailProductionStationLine');
    }
};
