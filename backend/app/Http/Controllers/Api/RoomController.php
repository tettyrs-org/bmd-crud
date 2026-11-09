<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        return RoomResource::collection(
            Room::query()->orderBy('kode_ruang')->get()
        );
    }
}
