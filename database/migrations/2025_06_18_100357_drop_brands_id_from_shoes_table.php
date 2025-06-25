<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('shoes', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            if (Schema::hasColumn('shoes', 'brands_id')) {
                $table->dropForeign(['brands_id']); // <- ini penting!
                $table->dropColumn('brands_id');
            }
        });
    }

    public function down(): void {
        Schema::table('shoes', function (Blueprint $table) {
            $table->unsignedBigInteger('brands_id')->nullable();
            $table->foreign('brands_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }
};
