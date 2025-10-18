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
        Schema::create('orang_hilangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_orang');
            $table->text('deskripsi_orang')->nullable();
            $table->unsignedInteger('umur')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->json('ciri_ciri')->nullable();
            $table->json('foto')->nullable();
            $table->json('kontak')->nullable();
            $table->string('lokasi_terakhir_dilihat')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->dateTime('tanggal_terakhir_dilihat')->nullable();
            $table->enum('status', ['Hilang', 'Ditemukan', 'Ditutup'])->default('Hilang');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_hilangs');
    }
};
