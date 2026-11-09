<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_barang' => $this->kode_barang,
            'nomor_register' => $this->nomor_register,
            'nama_barang' => $this->nama_barang,
            'kategori' => $this->kategori,
            'merk_tipe' => $this->merk_tipe,
            'tahun_perolehan' => $this->tahun_perolehan,
            'nilai_perolehan' => $this->nilai_perolehan,
            'kondisi' => $this->kondisi,
            'status' => $this->status,
            'ruang' => new RoomResource($this->whenLoaded('room')),
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
