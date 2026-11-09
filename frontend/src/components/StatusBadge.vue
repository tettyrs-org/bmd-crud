<script setup>
defineProps({ value: { type: String, required: true } })

const labels = {
  baik: 'Baik', kurang_baik: 'Kurang Baik', rusak_berat: 'Rusak Berat',
  aktif: 'Aktif', dipindahkan: 'Dipindahkan', dihapus: 'Dihapus',
}
// Warna berdasarkan makna: hijau = baik, kuning = perlu perhatian, merah = rusak.
const tones = {
  baik: 'ok', aktif: 'ok', kurang_baik: 'warn', rusak_berat: 'bad',
  dipindahkan: 'info', dihapus: 'muted',
}
</script>

<template>
  <span class="badge" :class="tones[value] ?? 'muted'">{{ labels[value] ?? value }}</span>
</template>

<style scoped>
.badge { display: inline-block; padding: 2px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
.ok { background: #dcfce7; color: #166534; }
.warn { background: #fef3c7; color: #92400e; }
.bad { background: #fee2e2; color: #991b1b; }
.info { background: #dbeafe; color: #1e40af; }
.muted { background: #f3f4f6; color: #374151; }
</style>
