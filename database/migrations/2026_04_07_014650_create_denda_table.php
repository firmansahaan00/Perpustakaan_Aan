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
        Schema::create('denda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->cascadeOnDelete();
            $table->enum('jenis', ['telat', 'rusak', 'hilang']);
            $table->integer('nominal_tagihan'); // Total yang harus dibayar
            $table->integer('nominal_baru')->nullable(); // Total nominal setelah revisi (jika ada)
            $table->text('keterangan')->nullable();
            $table->enum('status_denda', ['belum_lunas', 'lunas', 'sebagian', 'dibatalkan'])->default('belum_lunas');
            
            // Untuk tracking revisi/perubahan denda
            $table->foreignId('parent_id')->nullable()->constrained('denda')->nullOnDelete();
            $table->boolean('is_revisi')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};