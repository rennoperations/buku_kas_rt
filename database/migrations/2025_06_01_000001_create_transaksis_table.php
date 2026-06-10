<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            // Siapa yang bayar
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Detail pembayaran
            $table->unsignedBigInteger('nominal');           // dalam rupiah, contoh: 50000
            $table->string('periode', 20);                    // format: YYYY-MM, contoh: 2025-06
            $table->string('catatan')->nullable();           // keterangan dari struk / warga
            $table->string('struk_path')->nullable();        // path file foto struk di storage/public

            // Status: pending | approved | rejected
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // Siapa bendahara yang memverifikasi & kapan
            $table->foreignId('verified_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            // Index untuk query yang sering dipakai
            $table->index(['user_id', 'periode']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
