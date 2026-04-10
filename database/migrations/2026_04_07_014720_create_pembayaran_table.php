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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('denda_id')->constrained('denda')->cascadeOnDelete();
            $table->integer('nominal_bayar'); 
            $table->enum('metode', ['tunai', 'transfer']);
            $table->enum('tipe', ['bayar', 'refund'])->default('bayar');
            $table->timestamp('tanggal_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};