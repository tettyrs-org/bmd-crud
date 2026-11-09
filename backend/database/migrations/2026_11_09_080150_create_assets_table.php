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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->index();
            $table->string('nomor_register', 50)->index();
            $table->string('nama_barang', 255);
            $table->enum('kategori', ['peralatan_mesin', 'gedung_bangunan', 'jalan_irigasi', 'aset_tetap_lainnya'])->default('peralatan_mesin');
            $table->string('merk_tipe', 100)->nullable();
            $table->unsignedSmallInteger('tahun_perolehan');
            $table->decimal('nilai_perolehan', 15, 2)->default(0);
            $table->enum('kondisi', ['baik', 'kurang_baik', 'rusak_berat'])->default('baik');
            $table->enum('status', ['aktif', 'dipindahkan', 'dihapus'])->default('aktif');
            $table->foreignId('ruang_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['kondisi', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
