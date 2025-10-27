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
        Schema::create('hewan_hilangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_hewan')->nullable();
            $table->string('jenis_hewan');
            $table->string('ras')->nullable();
            $table->enum('jenis_kelamin', ['Jantan', 'Betina'])->nullable();
            $table->unsignedInteger('umur')->nullable();
            $table->string('warna');
            $table->json('ciri_ciri');
            $table->text('deskripsi_hewan');
            $table->json('foto');
            $table->json('kontak');
            $table->string('lokasi_terakhir_dilihat')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->dateTime('tanggal_terakhir_dilihat')->nullable();
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
        Schema::dropIfExists('hewan_hilangs');
    }
};
