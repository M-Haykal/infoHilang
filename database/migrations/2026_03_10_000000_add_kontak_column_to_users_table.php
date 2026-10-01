<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom `kontak` (JSON) ke tabel users.
     * Kolom ini menampung daftar kontak darurat tambahan milik user,
     * dan memang sudah dirujuk oleh User model (+ cast array) dan
     * SettingsController, namun kolomnya belum pernah dibuat.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'kontak')) {
            Schema::table('users', function (Blueprint $table) {
                $table->json('kontak')->nullable()->after('alamat');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'kontak')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('kontak');
            });
        }
    }
};
