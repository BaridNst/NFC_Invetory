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
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dateTime('tgl_harus_kembali')->nullable()->after('tgl_kembali');
            $table->integer('denda')->default(0)->after('status');
            $table->boolean('wa_sent')->default(false)->after('denda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['tgl_harus_kembali', 'denda', 'wa_sent']);
        });
    }
};
