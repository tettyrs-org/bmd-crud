<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;

    public const KATEGORI = ['peralatan_mesin', 'gedung_bangunan', 'jalan_irigasi', 'aset_tetap_lainnya'];
    public const KONDISI = ['baik', 'kurang_baik', 'rusak_berat'];
    public const STATUS = ['aktif', 'dipindahkan', 'dihapus'];

    protected $fillable = [
        'kode_barang',
        'nomor_register',
        'nama_barang',
        'kategori',
        'merk_tipe',
        'tahun_perolehan',
        'nilai_perolehan',
        'kondisi',
        'status',
        'ruang_id',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tahun_perolehan' => 'integer',
            'nilai_perolehan' => 'decimal:2',
        ];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'ruang_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '!=', 'dihapus');
    }
}
