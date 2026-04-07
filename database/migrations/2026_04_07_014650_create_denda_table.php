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

            $table->foreignId('peminjaman_id')
                ->constrained('peminjaman')
                ->cascadeOnDelete();

            $table->enum('jenis', ['telat', 'rusak', 'hilang']);

            $table->integer('nominal');

            $table->text('keterangan')->nullable();

            $table->boolean('bisa_revisi')->default(false);

            $table->enum('status', ['aktif', 'dibatalkan'])
                ->default('aktif');

            $table->foreignId('denda_parent_id')
                ->nullable()
                ->constrained('denda')
                ->nullOnDelete();

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