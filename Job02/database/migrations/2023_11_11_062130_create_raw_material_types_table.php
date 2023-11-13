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
        Schema::create('RawMaterialType', function (Blueprint $table) {
            $table->smallInteger('Id_RawMaterialType', true);
            $table->string('Name_RawMaterialType', 200);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('RawMaterialType');
    }
};
