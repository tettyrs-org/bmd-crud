<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetRequest;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'kondisi' => ['nullable', Rule::in(Asset::KONDISI)],
            'status' => ['nullable', Rule::in(Asset::STATUS)],
            'ruang_id' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = Asset::query()->with('room')->orderBy('kode_barang');

        if (! empty($filters['search'])) {
            $term = '%'.addcslashes($filters['search'], '%_\\').'%';
            $query->where(function ($q) use ($term) {
                $q->where('kode_barang', 'like', $term)
                    ->orWhere('nomor_register', 'like', $term)
                    ->orWhere('nama_barang', 'like', $term);
            });
        }

        $query
            ->when($filters['kondisi'] ?? null, fn ($q, $v) => $q->where('kondisi', $v))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['ruang_id'] ?? null, fn ($q, $v) => $q->where('ruang_id', $v));

        return AssetResource::collection(
            $query->paginate($filters['per_page'] ?? 10)->withQueryString()
        );
    }

    public function store(AssetRequest $request)
    {
        $asset = Asset::create($request->validated());

        return (new AssetResource($asset->load('room')))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Asset $asset)
    {
        return new AssetResource($asset->load('room'));
    }

    public function update(AssetRequest $request, Asset $asset)
    {
        $asset->update($request->validated());

        return new AssetResource($asset->load('room'));
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return response()->noContent();
    }
}
