import { http } from './http'

export const reportApi = {
  rooms: () => http.get('/reports/rooms').then((r) => r.data.data),
}
