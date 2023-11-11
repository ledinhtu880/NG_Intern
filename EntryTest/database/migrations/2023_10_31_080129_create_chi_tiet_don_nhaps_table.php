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
        Schema::create('chi_tiet_don_nhap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FK_Id_DonNhapHang');
            $table->unsignedBigInteger('FK_Id_MatHang');
            $table->integer('count');

            $table->foreign('FK_Id_DonNhapHang')->references('id')->on('don_nhap_hang');
            $table->foreign('FK_Id_MatHang')->references('Id_MatHang')->on('mat_hang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_nhap');
    }
};
