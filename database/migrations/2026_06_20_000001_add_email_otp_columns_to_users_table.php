<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom untuk fitur verifikasi email berbasis OTP.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'email_otp_code')) {
                $table->string('email_otp_code')->nullable()->after('email_verified_at');
            }
            if (! Schema::hasColumn('users', 'email_otp_expires_at')) {
                $table->timestamp('email_otp_expires_at')->nullable()->after('email_otp_code');
            }
            if (! Schema::hasColumn('users', 'email_otp_sent_at')) {
                $table->timestamp('email_otp_sent_at')->nullable()->after('email_otp_expires_at');
            }
            if (! Schema::hasColumn('users', 'email_otp_attempts')) {
                $table->unsignedTinyInteger('email_otp_attempts')->default(0)->after('email_otp_sent_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['email_otp_attempts', 'email_otp_sent_at', 'email_otp_expires_at', 'email_otp_code'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
