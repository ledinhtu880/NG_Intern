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
        Schema::create('Station', function (Blueprint $table) {
            $table->unsignedInteger('Id_Station', true);
            $table->string('Name_Station', 50);
            $table->string('Ip_Address', 20)->nullable();
            $table->smallInteger('FK_Id_StationType');
            $table->foreign('FK_Id_StationType')->references('Id_StationType')
                ->on('StationType')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Station');
    }
};
