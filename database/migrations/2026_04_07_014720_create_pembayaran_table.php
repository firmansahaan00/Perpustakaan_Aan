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
    
            // relasi ke denda
            $table->foreignId('denda_id')
                  ->constrained('denda')
                  ->cascadeOnDelete();
    
            // nominal pembayaran
            $table->integer('nominal');
    
            // tipe transaksi
            $table->enum('tipe', ['bayar', 'refund']);
    
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