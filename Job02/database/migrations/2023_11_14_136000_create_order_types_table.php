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
        Schema::create('OrderType', function (Blueprint $table) {
            $table->unsignedSmallInteger('Id_OrderType', true);
            $table->string('Name_OrderType', 100);
            $table->boolean('IsOrderInSystem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('OrderType');
    }
};
