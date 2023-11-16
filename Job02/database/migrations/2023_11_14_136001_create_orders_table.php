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
        Schema::create('Order', function (Blueprint $table) {
            $table->decimal('Id_Order', 18, 0)->primary();
            $table->unsignedInteger('FK_Id_Customer');
            $table->unsignedSmallInteger('FK_Id_OrderType');
            $table->dateTime('Date_Order');
            $table->dateTime('Date_Delivery')->nullable();
            $table->dateTime('Date_Reception')->nullable();
            $table->string('Note', 500)->nullable();

            $table->foreign('FK_Id_Customer')->references('Id_Customer')
                ->on('Customer')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('FK_Id_OrderType')->references('Id_OrderType')
                ->on('OrderType')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Order');
    }
};
