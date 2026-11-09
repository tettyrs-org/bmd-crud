import { http } from './http'

export const roomApi = {
  list: () => http.get('/rooms').then((r) => r.data.data),
}
