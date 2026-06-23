<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perizinans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->date('tgl_jemput');
            $table->time('jam_jemput');
            $table->date('tgl_kembali');
            $table->time('jam_kembali');

            $table->text('alasan');
            $table->string('file_pendukung')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected', 'out', 'returned'])
                  ->default('pending');

            $table->text('catatan_admin')->nullable();

            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->foreignId('checked_out_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('checked_out_at')->nullable();

            $table->foreignId('checked_in_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('checked_in_at')->nullable();

            $table->string('token_gatepass')->unique()->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perizinans');
    }
};