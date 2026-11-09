import { http } from './http'

export const assetApi = {
  list: (params) => http.get('/assets', { params }).then((r) => r.data),
  get: (id) => http.get(`/assets/${id}`).then((r) => r.data.data),
  create: (payload) => http.post('/assets', payload).then((r) => r.data.data),
  update: (id, payload) => http.put(`/assets/${id}`, payload).then((r) => r.data.data),
  remove: (id) => http.delete(`/assets/${id}`),
}
