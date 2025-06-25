<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('icon'); // 👈 menghapus kolom 'icon' dari tabel 'brands'
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('icon')->nullable(); // 👈 menambahkan kembali kalau rollback
        });
    }
};
