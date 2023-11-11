<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('don_nhap_hang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FK_Id_NCC');
            $table->enum('TrangThai', ['Đang chờ xử lý', 'Đã được xử lý', 'Đang vận chuyển', 'Hoàn thành'])->default('Đang chờ xử lý');
            $table->date('Ngay_DatHang')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('FK_Id_NCC')->references('Id_NCC')->on('nha_cung_cap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_nhap_hang');
    }
};
