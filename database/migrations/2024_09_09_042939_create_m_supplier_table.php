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
        Schema::table('m_supplier', function (Blueprint $table) {
            $table->renameColumn('supplier_kode, 10', 'supplier_kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_supplier', function (Blueprint $table) {
            // Kembalikan ke kondisi sebelumnya (misalnya jika rollback)
            $table->string('supplier_kode, 10')->change(); // Sesuaikan jika rollback diperlukan
        });
    }
};