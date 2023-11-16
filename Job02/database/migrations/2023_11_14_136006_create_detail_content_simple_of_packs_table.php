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
        Schema::create('DetailContentSimpleOfPack', function (Blueprint $table) {
            $table->decimal('FK_Id_SimpleContent', 18, 0);
            $table->foreign('FK_Id_SimpleContent')->references('Id_SimpleContent')
                ->on('ContentSimple');

            $table->decimal('FK_Id_PackContent', 18, 0);
            $table->foreign('FK_Id_PackContent')->references('Id_PackContent')
                ->on('ContentPack');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DetailContentSimpleOfPack');
    }
};
