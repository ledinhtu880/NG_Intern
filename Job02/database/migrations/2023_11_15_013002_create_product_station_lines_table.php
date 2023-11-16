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
        Schema::create('ProductStationLine', function (Blueprint $table) {
            $table->unsignedSmallInteger('Id_ProdStationLine', true);
            $table->string('Name_ProdStationLine', 100);
            $table->string('Description', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProductStationLine');
    }
};
