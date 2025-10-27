<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_hilangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('jenis_barang', 50);
            $table->string('merk_barang')->nullable();
            $table->string('warna_barang')->nullable();
            $table->text('deskripsi_barang')->nullable();
            $table->string('lokasi_terakhir_dilihat')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->dateTime('tanggal_terakhir_dilihat')->nullable();
            $table->json('ciri_ciri')->nullable();
            $table->json('kontak')->nullable();
            $table->json('foto')->nullable();
            $table->json('document_pendukung')->nullable();
            $table->enum('status', ['Hilang', 'Ditemukan', 'Ditutup'])->default('Hilang');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_hilangs');
    }
};
