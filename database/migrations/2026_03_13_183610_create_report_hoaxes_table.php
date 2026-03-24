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
        Schema::create('report_hoaxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_ditemukan_id')->constrained('laporan_ditemukans')->onDelete('cascade');
            $table->foreignId('reported_by_user_id')->constrained('users')->onDelete('cascade');
            $table->text('reason');
            $table->string('evidence')->nullable();
            $table->enum('status', ['pending', 'under_review', 'confirmed_hoax', 'not_hoax'])->default('pending');
            $table->foreignId('reviewed_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_hoaxes');
    }
};
