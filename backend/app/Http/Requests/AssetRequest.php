<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autentikasi dibahas pada iterasi berikutnya.
    }

    public function rules(): array
    {
        $id = $this->route('asset')?->id;

        $unique = fn (string $column) => Rule::unique('assets', $column)
            ->ignore($id)
            ->whereNull('deleted_at');

        return [
            'kode_barang' => ['required', 'string', 'max:50', $unique('kode_barang')],
            'nomor_register' => ['required', 'string', 'max:50', $unique('nomor_register')],
            'nama_barang' => ['required', 'string', 'min:3', 'max:255'],
            'kategori' => ['required', Rule::in(Asset::KATEGORI)],
            'merk_tipe' => ['nullable', 'string', 'max:100'],
            'tahun_perolehan' => ['required', 'integer', 'min:1900', 'max:'.now()->year],
            'nilai_perolehan' => ['required', 'numeric', 'min:0', 'max:999999999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'kondisi' => ['required', Rule::in(Asset::KONDISI)],
            'status' => ['required', Rule::in(Asset::STATUS)],
            'ruang_id' => ['nullable', 'integer', Rule::exists('rooms', 'id')],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_barang.unique' => 'Kode barang sudah digunakan.',
            'nomor_register.unique' => 'Nomor register sudah digunakan.',
            'nilai_perolehan.regex' => 'Nilai perolehan maksimal 2 angka desimal.',
        ];
    }
}
