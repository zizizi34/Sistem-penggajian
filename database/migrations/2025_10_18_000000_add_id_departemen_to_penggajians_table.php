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
        Schema::table('penggajians', function (Blueprint $table) {
            if (!Schema::hasColumn('penggajians', 'id_departemen')) {
                $table->foreignId('id_departemen')->nullable()->constrained('departemens')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penggajians', function (Blueprint $table) {
            if (Schema::hasColumn('penggajians', 'id_departemen')) {
                $table->dropForeign(['id_departemen']);
                $table->dropColumn('id_departemen');
            }
        });
    }
};
