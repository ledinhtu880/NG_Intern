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
        Schema::create('DetailStateCellOfPackWareHouse', function (Blueprint $table) {
            $table->integer('RowI');
            $table->integer('ColumnJ');
            $table->unsignedSmallInteger('FK_Id_StateCell');
            $table->integer('FK_Id_Station');
            $table->decimal('FK_Id_PackContent', 18, 0);

            $table->foreign('FK_Id_StateCell')->references('Id_StateCell')
                ->on('StateCell')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('FK_Id_Station')->references('Id_Station')
                ->on('Station')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('FK_Id_PackContent')->references('Id_PackContent')
                ->on('ContentPack')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DetailStateCellOfPackWareHouse');
    }
};