import { useFetch } from 'nuxt/app'

const baseUrl = 'http://localhost:8000/api'

export function useApiFetch<T>(endpoint: string, options: any = {}) {
  let token = ''
  if (import.meta.client) {
    token = localStorage.getItem('token') || ''
  }

  return useFetch<T>(`${baseUrl}${endpoint}`, {
    ...options,
    headers: {
      ...(options.headers || {}),
      Authorization: `Bearer ${token}`,
    },
  })
}