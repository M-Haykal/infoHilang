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

            // ubah menjadi nullable
            $table->string('nama_penemu')->nullable()->change();
            $table->string('kontak_penemu')->nullable()->change();

            // tambah slug
            // $table->string('slug')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_ditemukans', function (Blueprint $table) {

            $table->string('nama_penemu')->nullable(false)->change();
            $table->string('kontak_penemu')->nullable(false)->change();

            // $table->dropColumn('slug');
        });
    }
};
