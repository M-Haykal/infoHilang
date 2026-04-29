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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            
            // Polymorphic Relation untuk semua entitas (Barang, Hewan, Orang Hilang)
            $table->unsignedBigInteger('rewardable_id');
            $table->string('rewardable_type');
            
            // User yang membuat laporan dan memberikan reward
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // User yang berhasil menemukan (akan diisi nanti)
            $table->foreignId('receiver_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // Jumlah Reward
            $table->integer('amount');
            
            // Status Reward
            $table->enum('status', ['pending', 'waiting_approval', 'approved', 'paid', 'cancelled', 'refunded'])->default('pending');
            
            // Midtrans Payment
            $table->string('midtrans_order_id')->nullable()->unique();
            $table->enum('payment_status', ['unpaid', 'paid', 'expired', 'failed'])->default('unpaid');
            
            // Catatan Admin
            $table->text('admin_note')->nullable();
            
            // Tanggal dibayar
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index(['rewardable_id', 'rewardable_type']);
            $table->index('status');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
