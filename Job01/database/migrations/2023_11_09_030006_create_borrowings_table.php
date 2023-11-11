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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->unsignedInteger('BorrowingID', true);
            $table->unsignedInteger('BookID');
            $table->foreign('BookID')->references('BookID')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('MemberID');
            $table->date('BorrowDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('DueDate')->nullable();
            $table->date('ReturnedDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
