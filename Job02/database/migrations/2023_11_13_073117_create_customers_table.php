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
        Schema::create('Customer', function (Blueprint $table) {
            $table->unsignedInteger('Id_Customer', true);
            $table->string('Name_Customer', 300);
            $table->string('Name_Contact', 200);
            $table->string('Email', 150);
            $table->string('Phone', 20);
            $table->string('Address', 500);
            $table->string('ZipCode', 20);
            $table->smallInteger('FK_Id_Mode_Transport');
            $table->foreign('FK_Id_Mode_Transport')->references('Id_ModeTransport')->on('ModeTransport')->onDelete('cascade')->onUpdate('cascade');
            $table->string('Time_Reception', 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Customer');
    }
};
