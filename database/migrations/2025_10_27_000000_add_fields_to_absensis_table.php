<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->unsignedBigInteger('id_pegawai')->nullable();
            $table->enum('jenis', ['masuk', 'keluar'])->default('masuk');
            $table->timestamp('waktu')->useCurrent();
            $table->text('keterangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'id_pegawai', 'jenis', 'waktu', 'keterangan']);
        });
    }
};
