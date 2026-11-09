<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_ruang' => $this->kode_ruang,
            'nama_ruang' => $this->nama_ruang,
            'lantai' => $this->lantai,
        ];
    }
}
