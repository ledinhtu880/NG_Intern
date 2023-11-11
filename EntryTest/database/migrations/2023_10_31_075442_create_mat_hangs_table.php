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
        Schema::create('mat_hang', function (Blueprint $table) {
            $table->unsignedBigInteger('Id_MatHang', true);
            $table->string('Ten_MatHang');
            $table->string('DonViTinh');
            $table->double('DonGia');
            $table->unsignedBigInteger('FK_Id_LoaiHang');
            $table->foreign('FK_Id_LoaiHang')->references('Id_LoaiHang')->on('loai_hang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mat_hang');
    }
};
