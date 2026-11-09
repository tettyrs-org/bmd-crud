<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = ['kode_ruang', 'nama_ruang', 'lantai'];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'ruang_id');
    }
}