<script setup>
import { ref, reactive, watch, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import { assetApi } from '../api/assets'
import { roomApi } from '../api/rooms'
import { parseError } from '../api/http'
import StatusBadge from '../components/StatusBadge.vue'

const items = ref([])
const meta = ref(null)
const rooms = ref([])
const loading = ref(false)
const error = ref('')
const filters = reactive({ search: '', kondisi: '', status: '', ruang_id: '', page: 1 })

async function load() {
  loading.value = true
  error.value = ''
  try {
    const params = Object.fromEntries(Object.entries(filters).filter(([, v]) => v !== ''))
    const res = await assetApi.list(params)
    items.value = res.data
    meta.value = res.meta
  } catch (e) {
    error.value = parseError(e).message
  } finally {
    loading.value = false
  }
}

async function remove(asset) {
  if (!confirm(`Hapus aset "${asset.nama_barang}"?`)) return
  try {
    await assetApi.remove(asset.id)
    await load()
  } catch (e) {
    alert(parseError(e).message)
  }
}

watch(() => [filters.search, filters.kondisi, filters.status, filters.ruang_id], () => {
  if (filters.page !== 1) filters.page = 1 // watcher halaman akan memanggil load()
  else load()
})
watch(() => filters.page, load)

onMounted(async () => {
  rooms.value = await roomApi.list()
  load()
})
</script>

<template>
  <div class="card">
    <div class="page-head">
      <h2>Daftar Aset</h2>
      <RouterLink class="btn" to="/assets/baru">+ Tambah Aset</RouterLink>
    </div>

    <div class="toolbar">
      <input
        v-model.trim="filters.search"
        class="search"
        type="search"
        aria-label="Cari aset"
        placeholder="Cari kode, nomor register, atau nama"
      />
      <select v-model="filters.kondisi" aria-label="Filter kondisi">
        <option value="">Semua kondisi</option>
        <option value="baik">Baik</option>
        <option value="kurang_baik">Kurang Baik</option>
        <option value="rusak_berat">Rusak Berat</option>
      </select>
      <select v-model="filters.status" aria-label="Filter status">
        <option value="">Semua status</option>
        <option value="aktif">Aktif</option>
        <option value="dipindahkan">Dipindahkan</option>
        <option value="dihapus">Dihapus</option>
      </select>
      <select v-model="filters.ruang_id" aria-label="Filter ruang">
        <option value="">Semua ruang</option>
        <option v-for="r in rooms" :key="r.id" :value="r.id">{{ r.nama_ruang }}</option>
      </select>
    </div>

    <p v-if="error" class="alert" role="alert">{{ error }}</p>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama barang</th>
            <th>Ruang</th>
            <th>Kondisi</th>
            <th>Status</th>
            <th class="num">Nilai (Rp)</th>
            <th class="actions">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="loading">
            <td colspan="7" class="empty">Memuat data...</td>
          </tr>
          <tr v-else-if="!items.length">
            <td colspan="7" class="empty">Tidak ada data yang cocok dengan filter.</td>
          </tr>
          <tr v-for="a in items" :key="a.id">
            <td>{{ a.kode_barang }}</td>
            <td class="wrap">{{ a.nama_barang }}</td>
            <td>{{ a.ruang?.nama_ruang ?? '-' }}</td>
            <td><StatusBadge :value="a.kondisi" /></td>
            <td><StatusBadge :value="a.status" /></td>
            <td class="num">{{ Number(a.nilai_perolehan).toLocaleString('id-ID') }}</td>
            <td class="actions">
              <RouterLink class="btn ghost sm" :to="`/assets/${a.id}/ubah`">Ubah</RouterLink>
              <button class="btn danger sm" type="button" @click="remove(a)">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="meta" class="pager">
      <button class="btn ghost sm" type="button" :disabled="meta.current_page <= 1" @click="filters.page--">Sebelumnya</button>
      <span>Halaman {{ meta.current_page }} dari {{ meta.last_page }}</span>
      <button class="btn ghost sm" type="button" :disabled="meta.current_page >= meta.last_page" @click="filters.page++">Berikutnya</button>
    </div>
  </div>
</template>
