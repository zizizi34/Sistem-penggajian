<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->string('nik_pegawai', 50)->unique();
            $table->string('nama_pegawai', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('bank_pegawai', 50)->nullable();
            $table->string('no_rekening', 50)->nullable();
            $table->string('npwp', 50)->nullable();

            // Relasi ke tabel lain
           $table->foreignId('id_ptkp_status')->nullable()->constrained('ptkp_status')->onDelete('set null');
            $table->foreignId('id_jabatan')->nullable()->constrained('jabatans')->onDelete('set null');
            $table->foreignId('id_departemen')->nullable()->constrained('departemens')->onDelete('set null');

            $table->date('tanggal_masuk')->nullable();
            $table->decimal('gaji_pokok', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Hapus tabel jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
