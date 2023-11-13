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
        Schema::create('RawMaterial', function (Blueprint $table) {
            $table->unsignedInteger('Id_RawMaterial', true);
            $table->string('Name_RawMaterial', 200);
            $table->string('Unit', 50);
            $table->float('count');
            $table->smallInteger('FK_Id_RawMaterialType');
            $table->foreign('FK_Id_RawMaterialType')->references('Id_RawMaterialType')
                ->on('RawMaterialType')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('RawMaterial');
    }
};
