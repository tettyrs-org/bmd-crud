<?php

namespace App\Services;

use App\Models\Room;
use Illuminate\Support\Collection;

class ReportService
{
    public function roomSummary(): Collection
    {
        $rooms = Room::query()
            ->withCount(['assets as jumlah_aset' => fn ($q) => $q->active()])
            ->withSum(['assets as total_nilai' => fn ($q) => $q->active()], 'nilai_perolehan')
            ->withCount([
                'assets as baik_count' => fn ($q) => $q->active()->where('kondisi', 'baik'),
                'assets as kurang_baik_count' => fn ($q) => $q->active()->where('kondisi', 'kurang_baik'),
                'assets as rusak_berat_count' => fn ($q) => $q->active()->where('kondisi', 'rusak_berat'),
            ])
            ->orderBy('kode_ruang')
            ->get();

        return $rooms->map(fn (Room $room) => [
            'ruang' => [
                'id' => $room->id,
                'kode_ruang' => $room->kode_ruang,
                'nama_ruang' => $room->nama_ruang,
            ],
            'jumlah_aset' => (int) $room->jumlah_aset,
            'total_nilai' => number_format((float) $room->total_nilai, 2, '.', ''),
            'per_kondisi' => [
                'baik' => (int) $room->baik_count,
                'kurang_baik' => (int) $room->kurang_baik_count,
                'rusak_berat' => (int) $room->rusak_berat_count,
            ],
        ])->values();
    }
}
