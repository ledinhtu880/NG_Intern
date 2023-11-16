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
        Schema::create('StationType', function (Blueprint $table) {
            $table->unsignedSmallInteger('Id_StationType')->primary();
            $table->string('Name_StationType', 100);
            $table->string('Description', 500)->nullable();
            $table->string('PathImage', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('StationType');
    }
};
