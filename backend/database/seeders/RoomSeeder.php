<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('rooms')->upsert([
            ['kode_ruang' => 'R-01', 'nama_ruang' => 'Ruang Rapat Utama', 'lantai' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['kode_ruang' => 'R-02', 'nama_ruang' => 'Ruang Kepala Bidang', 'lantai' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['kode_ruang' => 'R-03', 'nama_ruang' => 'Gudang Barang', 'lantai' => 0, 'created_at' => $now, 'updated_at' => $now],
        ], ['kode_ruang'], ['nama_ruang', 'lantai', 'updated_at']);
    }
}
