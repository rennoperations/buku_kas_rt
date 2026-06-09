<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom no_wa jika belum ada
            if (!Schema::hasColumn('users', 'no_wa')) {
                $table->string('no_wa', 20)->nullable()->after('no_rumah');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('no_wa');
        });
    }
};
