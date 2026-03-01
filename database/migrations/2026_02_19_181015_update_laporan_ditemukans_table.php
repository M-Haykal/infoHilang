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
        Schema::table('laporan_ditemukans', function (Blueprint $table) {

            // ubah bukti_ditemukan jadi json
            $table->json('bukti_ditemukan')->nullable()->change();

            // ubah lokasi_ditemukan jadi text
            $table->text('lokasi_ditemukan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_ditemukans', function (Blueprint $table) {

            // rollback ke string
            $table->string('bukti_ditemukan')->nullable()->change();

            // rollback ke string
            $table->string('lokasi_ditemukan')->nullable()->change();
        });
    }
};
