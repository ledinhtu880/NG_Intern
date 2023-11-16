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
        Schema::create('ContentPack', function (Blueprint $table) {
            $table->decimal('Id_PackContent', 18, 0)->primary();
            $table->integer('Count_Pack');
            $table->float('Price_Pack');
            $table->decimal('FK_Id_Order', 18, 0);

            $table->foreign('FK_Id_Order')->references('Id_Order')
                ->on('Order')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ContentPack');
    }
};
