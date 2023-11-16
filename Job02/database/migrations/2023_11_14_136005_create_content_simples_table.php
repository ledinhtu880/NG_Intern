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
        Schema::create('ContentSimple', function (Blueprint $table) {
            $table->decimal('Id_SimpleContent', 18, 0)->primary();
            $table->unsignedInteger('FK_Id_RawMaterial');
            $table->integer('Count_RawMaterial');
            $table->unsignedSmallInteger('FK_Id_ContainerType');
            $table->integer('Count_Container');
            $table->float('Price_Container');
            $table->decimal('FK_Id_Order', 18, 0);
            $table->boolean('ContainerProvided');
            $table->boolean('PedestalProvided');
            $table->boolean('RFIDProvided');
            $table->binary('RFID')->length(2048)->nullable();
            $table->boolean('RawMaterialProvided');

            $table->foreign('FK_Id_RawMaterial')->references('Id_RawMaterial')
                ->on('RawMaterial')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('FK_Id_ContainerType')->references('Id_ContainerType')
                ->on('ContainerType')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('FK_Id_Order')->references('Id_Order')
                ->on('Order')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ContentSimple');
    }
};
