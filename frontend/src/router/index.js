import { createRouter, createWebHistory } from 'vue-router'
import AssetList from '../views/AssetList.vue'
import AssetForm from '../views/AssetForm.vue'
import ReportView from '../views/ReportView.vue'

export default createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: '/assets' },
    { path: '/assets', name: 'assets', component: AssetList },
    { path: '/assets/baru', name: 'asset-create', component: AssetForm },
    { path: '/assets/:id/ubah', name: 'asset-edit', component: AssetForm, props: true },
    { path: '/laporan', name: 'report', component: ReportView },
  ],
})
