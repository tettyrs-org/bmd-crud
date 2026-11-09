<script setup>
import { ref, computed, onMounted } from 'vue'
import { reportApi } from '../api/reports'
import { parseError } from '../api/http'

const rows = ref([])
const loading = ref(true)
const error = ref('')

onMounted(async () => {
  try {
    rows.value = await reportApi.rooms()
  } catch (e) {
    error.value = parseError(e).message
  } finally {
    loading.value = false
  }
})

const formatRupiah = (v) => Number(v).toLocaleString('id-ID')

// Baris total dihitung dari data yang sudah difilter backend (aset aktif saja).
const totals = computed(() => rows.value.reduce((t, r) => ({
  jumlah: t.jumlah + r.jumlah_aset,
  nilai: t.nilai + Number(r.total_nilai),
  baik: t.baik + r.per_kondisi.baik,
  kurang_baik: t.kurang_baik + r.per_kondisi.kurang_baik,
  rusak_berat: t.rusak_berat + r.per_kondisi.rusak_berat,
}), { jumlah: 0, nilai: 0, baik: 0, kurang_baik: 0, rusak_berat: 0 }))
</script>

<template>
  <div class="card">
    <div class="page-head">
      <h2>Laporan Aset per Ruang</h2>
    </div>
    <p class="subtitle">Ringkasan aset per ruang. Aset yang sudah dihapus tidak ikut dihitung.</p>

    <div v-if="rows.length" class="tiles">
      <div class="tile">
        <span class="tile-label">Jumlah ruang</span>
        <strong>{{ rows.length }}</strong>
      </div>
      <div class="tile">
        <span class="tile-label">Total aset</span>
        <strong>{{ totals.jumlah }}</strong>
      </div>
      <div class="tile">
        <span class="tile-label">Total nilai (Rp)</span>
        <strong>{{ formatRupiah(totals.nilai) }}</strong>
      </div>
      <div class="tile bad">
        <span class="tile-label">Rusak berat</span>
        <strong>{{ totals.rusak_berat }}</strong>
      </div>
    </div>

    <p v-if="error" class="alert" role="alert">{{ error }}</p>
    <p v-if="loading" class="empty">Memuat data...</p>

    <div v-else class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Ruang</th>
            <th class="num">Jumlah aset</th>
            <th class="num">Total nilai (Rp)</th>
            <th class="num">Baik</th>
            <th class="num">Kurang Baik</th>
            <th class="num">Rusak Berat</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="r in rows" :key="r.ruang.id">
            <td><span class="kode">{{ r.ruang.kode_ruang }}</span>{{ r.ruang.nama_ruang }}</td>
            <td class="num">{{ r.jumlah_aset }}</td>
            <td class="num">{{ formatRupiah(r.total_nilai) }}</td>
            <td class="num">{{ r.per_kondisi.baik }}</td>
            <td class="num">{{ r.per_kondisi.kurang_baik }}</td>
            <td class="num">{{ r.per_kondisi.rusak_berat }}</td>
          </tr>
          <tr v-if="!rows.length">
            <td colspan="6" class="empty">Belum ada ruang.</td>
          </tr>
        </tbody>
        <tfoot v-if="rows.length">
          <tr>
            <td>Total</td>
            <td class="num">{{ totals.jumlah }}</td>
            <td class="num">{{ formatRupiah(totals.nilai) }}</td>
            <td class="num">{{ totals.baik }}</td>
            <td class="num">{{ totals.kurang_baik }}</td>
            <td class="num">{{ totals.rusak_berat }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</template>

<style scoped>
.subtitle { color: var(--muted); font-size: 14px; margin: 4px 0 16px; }
.tiles { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 12px; margin-bottom: 16px; }
.tile { border: 1px solid var(--border); border-radius: var(--radius); padding: 12px 14px; display: flex; flex-direction: column; gap: 4px; }
.tile-label { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
.tile strong { font-size: 20px; font-variant-numeric: tabular-nums; }
.tile.bad strong { color: #b91c1c; }
.kode { display: inline-block; font-family: ui-monospace, Consolas, monospace; font-size: 12px; background: #eef2ff; color: #3730a3; padding: 1px 6px; border-radius: 4px; margin-right: 8px; }
</style>
