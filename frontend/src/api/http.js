import axios from 'axios'
export const http = axios.create({
    baseURL: '/api',
    headers: { Accept: 'application/json' },
})

export function parseError(err){
    const data = err.response?.data?.error
    return {
        status: err.response?.status ?? 0,
        message: data?.message ?? 'Tidak dapat terhubung ke server.',
        details: data?.details ?? null,
    }
}