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
        Schema::create('laporan_ditemukans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penemu');
            $table->string('kontak_penemu');
            $table->text('keterangan')->nullable();
            $table->string('lokasi_ditemukan')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->dateTime('tanggal_ditemukan')->nullable();
            $table->string('bukti_ditemukan')->nullable();
            $table->morphs('foundable');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('is_confirmed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_ditemukans');
    }
};
