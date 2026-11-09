<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { assetApi } from '../api/assets'
import { roomApi } from '../api/rooms'
import { parseError } from '../api/http'

const props = defineProps({ id: { type: String, default: null } })
const router = useRouter()

const isEdit = computed(() => !!props.id)
const rooms = ref([])
const saving = ref(false)
const formError = ref('')
const fieldErrors = ref({})

const form = reactive({
  kode_barang: '', nomor_register: '', nama_barang: '', kategori: 'peralatan_mesin',
  merk_tipe: '', tahun_perolehan: new Date().getFullYear(), nilai_perolehan: 0,
  kondisi: 'baik', status: 'aktif', ruang_id: '', keterangan: '',
})

onMounted(async () => {
  rooms.value = await roomApi.list()
  if (isEdit.value) {
    const a = await assetApi.get(props.id)
    Object.assign(form, {
      kode_barang: a.kode_barang,
      nomor_register: a.nomor_register,
      nama_barang: a.nama_barang,
      kategori: a.kategori,
      merk_tipe: a.merk_tipe ?? '',
      tahun_perolehan: a.tahun_perolehan,
      nilai_perolehan: a.nilai_perolehan,
      kondisi: a.kondisi,
      status: a.status,
      ruang_id: a.ruang?.id ?? '',
      keterangan: a.keterangan ?? '',
    })
  }
})

const fieldError = (name) => fieldErrors.value[name]?.[0]
// Kelas 'invalid' dipakai input yang gagal validasi (border merah).
const invalid = (name) => (fieldError(name) ? 'invalid' : '')

async function submit() {
  saving.value = true
  formError.value = ''
  fieldErrors.value = {}
  const payload = { ...form, ruang_id: form.ruang_id === '' ? null : Number(form.ruang_id) }
  try {
    if (isEdit.value) await assetApi.update(props.id, payload)
    else await assetApi.create(payload)
    router.push('/assets')
  } catch (e) {
    const err = parseError(e)
    if (err.status === 422) fieldErrors.value = err.details ?? {}
    formError.value = err.message
  } finally {
    saving.value = false
  }
}
</script>

<template>
  <div class="card">
    <div class="page-head">
      <h2>{{ isEdit ? 'Ubah Aset' : 'Tambah Aset' }}</h2>
      <span class="hint"><span class="req">*</span> wajib diisi</span>
    </div>

    <p v-if="formError" class="alert" role="alert">{{ formError }}</p>

    <form class="form-grid" novalidate @submit.prevent="submit">
      <label class="field">
        <span class="field-label">Kode barang<span class="req" aria-hidden="true">*</span></span>
        <input v-model.trim="form.kode_barang" :class="invalid('kode_barang')" required maxlength="50" />
        <span v-if="fieldError('kode_barang')" class="error">{{ fieldError('kode_barang') }}</span>
      </label>

      <label class="field">
        <span class="field-label">Nomor register<span class="req" aria-hidden="true">*</span></span>
        <input v-model.trim="form.nomor_register" :class="invalid('nomor_register')" required maxlength="50" />
        <span v-if="fieldError('nomor_register')" class="error">{{ fieldError('nomor_register') }}</span>
      </label>

      <label class="field full">
        <span class="field-label">Nama barang<span class="req" aria-hidden="true">*</span></span>
        <input v-model.trim="form.nama_barang" :class="invalid('nama_barang')" required minlength="3" maxlength="255" />
        <span v-if="fieldError('nama_barang')" class="error">{{ fieldError('nama_barang') }}</span>
      </label>

      <label class="field">
        <span class="field-label">Kategori<span class="req" aria-hidden="true">*</span></span>
        <select v-model="form.kategori" :class="invalid('kategori')">
          <option value="peralatan_mesin">Peralatan &amp; Mesin</option>
          <option value="gedung_bangunan">Gedung &amp; Bangunan</option>
          <option value="jalan_irigasi">Jalan, Irigasi &amp; Jaringan</option>
          <option value="aset_tetap_lainnya">Aset Tetap Lainnya</option>
        </select>
        <span v-if="fieldError('kategori')" class="error">{{ fieldError('kategori') }}</span>
      </label>

      <label class="field">
        <span class="field-label">Merk / tipe</span>
        <input v-model.trim="form.merk_tipe" :class="invalid('merk_tipe')" maxlength="100" />
        <span v-if="fieldError('merk_tipe')" class="error">{{ fieldError('merk_tipe') }}</span>
      </label>

      <label class="field">
        <span class="field-label">Tahun perolehan<span class="req" aria-hidden="true">*</span></span>
        <input v-model.number="form.tahun_perolehan" :class="invalid('tahun_perolehan')" type="number" min="1900" required />
        <span v-if="fieldError('tahun_perolehan')" class="error">{{ fieldError('tahun_perolehan') }}</span>
      </label>

      <label class="field">
        <span class="field-label">Nilai perolehan (Rp)<span class="req" aria-hidden="true">*</span></span>
        <input v-model="form.nilai_perolehan" :class="invalid('nilai_perolehan')" type="number" min="0" step="0.01" required />
        <span v-if="fieldError('nilai_perolehan')" class="error">{{ fieldError('nilai_perolehan') }}</span>
      </label>

      <label class="field">
        <span class="field-label">Kondisi<span class="req" aria-hidden="true">*</span></span>
        <select v-model="form.kondisi" :class="invalid('kondisi')">
          <option value="baik">Baik</option>
          <option value="kurang_baik">Kurang Baik</option>
          <option value="rusak_berat">Rusak Berat</option>
        </select>
        <span v-if="fieldError('kondisi')" class="error">{{ fieldError('kondisi') }}</span>
      </label>

      <label class="field">
        <span class="field-label">Status<span class="req" aria-hidden="true">*</span></span>
        <select v-model="form.status" :class="invalid('status')">
          <option value="aktif">Aktif</option>
          <option value="dipindahkan">Dipindahkan</option>
          <option value="dihapus">Dihapus</option>
        </select>
        <span v-if="fieldError('status')" class="error">{{ fieldError('status') }}</span>
      </label>

      <label class="field">
        <span class="field-label">Ruang</span>
        <select v-model="form.ruang_id" :class="invalid('ruang_id')">
          <option value="">Belum ditempatkan</option>
          <option v-for="r in rooms" :key="r.id" :value="r.id">{{ r.kode_ruang }} - {{ r.nama_ruang }}</option>
        </select>
        <span v-if="fieldError('ruang_id')" class="error">{{ fieldError('ruang_id') }}</span>
      </label>

      <label class="field full">
        <span class="field-label">Keterangan</span>
        <textarea v-model="form.keterangan" rows="3"></textarea>
      </label>

      <div class="form-actions full">
        <RouterLink class="btn ghost" to="/assets">Batal</RouterLink>
        <button class="btn" type="submit" :disabled="saving">{{ saving ? 'Menyimpan...' : 'Simpan' }}</button>
      </div>
    </form>
  </div>
</template>
